const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
const toast = (message, type = 'success') => {
  const area = document.getElementById('toastArea'); if (!area) return;
  const item = document.createElement('div'); item.className = 'toast-note ' + type; item.setAttribute('role','status'); item.textContent = message;
  area.append(item); setTimeout(() => item.remove(), 5000);
};
document.querySelector('.mobile-menu')?.addEventListener('click', event => {
  const nav = document.querySelector('.main-nav'); const open = nav.classList.toggle('mobile-open');
  event.currentTarget.setAttribute('aria-expanded', String(open));
});
document.querySelector('[data-account-info]')?.addEventListener('click', () => {
  toast('O acesso à conta não está configurado neste sistema.', 'info');
});
document.querySelectorAll('[data-action]').forEach(button => button.addEventListener('click', async () => {
  const {id, action} = button.dataset; button.disabled = true;
  try {
    const response = await fetch('/api/reservas/' + id + '/' + action, {method:'PATCH',headers:{Accept:'application/json','X-CSRF-TOKEN':csrf}});
    const result = await response.json();
    if (!response.ok) {
      const alert = document.getElementById('capacity-alert');
      if (response.status === 409 && action === 'confirmar' && alert) {
        document.getElementById('capacity-alert-message').textContent = 'Não foi possível confirmar a reserva. ' + (result.mensagem || 'Não há vagas suficientes.');
        alert.hidden = false;
      }
      toast(result.mensagem || 'Não foi possível atualizar a reserva.', 'error'); return;
    }
    const alert = document.getElementById('capacity-alert'); if (alert) alert.hidden = true;
    toast(action === 'confirmar' ? 'Reserva confirmada.' : 'Reserva cancelada.');
    const row = button.closest('tr'); const status = row?.querySelector('.status-pill');
    if (action === 'confirmar' && status) { status.textContent='Confirmada'; status.className='status-pill confirmada'; button.remove(); }
    if (action === 'cancelar' && status) { status.textContent='Cancelada'; status.className='status-pill cancelada'; row.querySelector('.actions').innerHTML='<span class="muted">—</span>'; }
  } catch { toast('Falha de conexão. Tente novamente.', 'error'); }
  finally { if (button.isConnected) button.disabled = false; }
}));
const form = document.getElementById('reservationForm');
if (form) {
  const date = document.getElementById('tour-date'), options = document.getElementById('departure-options'), count = document.getElementById('departure-count');
  const people = document.getElementById('people-count'), help = document.getElementById('seats-help'), submit = document.getElementById('submit-booking');
  const banner = document.getElementById('selection-banner'), summary = document.getElementById('selected-summary'), remainingText = document.getElementById('remaining-summary');
  function syncSelection() {
    const selected = form.querySelector('input[name="saida_id"]:checked');
    options.querySelectorAll('.departure-option').forEach(card => { const input=card.querySelector('input'); card.classList.toggle('selected', input.checked); card.querySelector('.selection-label').textContent = input.checked ? 'Selecionado' : (card.classList.contains('sold-out') ? 'Sem vagas' : 'Disponível'); });
    if (!selected) { banner.hidden=true; submit.disabled=true; help.textContent='Selecione uma saída disponível'; return; }
    const max=Number(selected.dataset.remaining); people.max=String(Math.min(15,max)); people.value=String(Math.min(Math.max(1,Number(people.value)||1),Number(people.max)));
    banner.hidden=false; summary.textContent=selected.dataset.name + ' às ' + selected.dataset.time; remainingText.textContent=max + (max===1?' vaga':' vagas') + ' disponíveis';
    help.textContent='Máximo permitido para esta saída: ' + people.max + (people.max==='1'?' pessoa':' pessoas');
    submit.disabled = max===0 || Number(people.value)>max;
  }
  async function loadDepartures() {
    options.innerHTML='<div class="empty-options">Carregando saídas…</div>';
    try {
      const res=await fetch('/api/saidas?data='+encodeURIComponent(date.value),{headers:{Accept:'application/json'}});
      if(!res.ok) throw new Error();
      const payload=await res.json(), departures=payload.data || [];
      count.textContent=departures.length + (departures.length===1?' saída programada':' saídas programadas');
      if (!departures.length) { options.innerHTML='<div class="empty-options">Nenhuma saída programada para esta data.</div>'; banner.hidden=true; submit.disabled=true; return; }
      options.innerHTML=departures.map((d,i)=>{
        const sold=d.vagas_restantes===0, tone=sold?'full':(d.vagas_ocupadas/d.vagas_total>=.7?'limited':'available');
        const safeName=d.passeio.replaceAll('&','&amp;').replaceAll('"','&quot;').replaceAll('<','&lt;');
        return '<label class="departure-option '+(sold?'sold-out':'')+'"><input type="radio" name="saida_id" value="'+d.id+'" data-name="'+safeName+'" data-time="'+d.horario+'" data-remaining="'+d.vagas_restantes+'" '+(i===0&&!sold?'checked':'')+' '+(sold?'disabled':'')+'><span class="option-top"><strong><span class="material-symbols-outlined">sailing</span>'+safeName+'</strong><span class="availability '+tone+'">'+(sold?'0 vagas · ESGOTADO':d.vagas_restantes+' vagas restantes')+'</span></span><span class="option-bottom"><span><span class="material-symbols-outlined">schedule</span>'+d.horario+'</span><span class="selection-label">'+(i===0&&!sold?'Selecionado':(sold?'Sem vagas':'Disponível'))+'</span></span></label>';
      }).join('');
      options.querySelectorAll('input').forEach(input=>input.addEventListener('change',syncSelection)); syncSelection();
    } catch { options.innerHTML='<div class="empty-options">Não foi possível carregar as saídas. Verifique a conexão e tente novamente.</div>'; submit.disabled=true; }
  }
  date.addEventListener('change',loadDepartures); people.addEventListener('input',syncSelection);
  form.addEventListener('submit',async event=>{
    event.preventDefault(); if(submit.disabled)return; submit.disabled=true;
    try {
      const response=await fetch('/api/reservas',{method:'POST',headers:{'Content-Type':'application/json',Accept:'application/json','X-CSRF-TOKEN':csrf},body:JSON.stringify({saida_id:form.querySelector('[name="saida_id"]:checked')?.value,nome_cliente:document.getElementById('customer-name').value,telefone:document.getElementById('customer-phone').value,pessoas:Number(people.value)})});
      const result=await response.json();
      if(!response.ok){toast(result.mensagem || Object.values(result.errors||{}).flat().join(' ') || 'Não foi possível salvar a reserva.','error');return;}
      toast('Reserva ' + result.data.codigo + ' criada como pendente.'); setTimeout(()=>location.assign('/reservas'),900);
    } catch { toast('Falha de conexão. Tente novamente.', 'error'); }
    finally { syncSelection(); }
  });
  options.querySelectorAll('input').forEach(input=>input.addEventListener('change',syncSelection)); syncSelection();
}
