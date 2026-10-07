---
name: Reservow Operations
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#434653'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#737784'
  outline-variant: '#c3c6d5'
  surface-tint: '#1d59c1'
  primary: '#003c90'
  on-primary: '#ffffff'
  primary-container: '#0f52ba'
  on-primary-container: '#bcceff'
  inverse-primary: '#b0c6ff'
  secondary: '#006a61'
  on-secondary: '#ffffff'
  secondary-container: '#86f2e4'
  on-secondary-container: '#006f66'
  tertiary: '#653400'
  on-tertiary: '#ffffff'
  tertiary-container: '#874700'
  on-tertiary-container: '#ffc292'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d9e2ff'
  primary-fixed-dim: '#b0c6ff'
  on-primary-fixed: '#001945'
  on-primary-fixed-variant: '#00419c'
  secondary-fixed: '#89f5e7'
  secondary-fixed-dim: '#6bd8cb'
  on-secondary-fixed: '#00201d'
  on-secondary-fixed-variant: '#005049'
  tertiary-fixed: '#ffdcc3'
  tertiary-fixed-dim: '#ffb77d'
  on-tertiary-fixed: '#2f1500'
  on-tertiary-fixed-variant: '#6e3900'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-xl:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
    letterSpacing: -0.015em
  headline-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
    letterSpacing: -0.01em
  body-lg:
    fontFamily: Inter
    fontSize: 15px
    fontWeight: '400'
    lineHeight: 22px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Inter
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.02em
  label-sm:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 14px
    letterSpacing: 0.04em
  numeric-data:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  gutter: 1rem
  gutter-desktop: 1.25rem
  margin: 1rem
  margin-desktop: 1.5rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 0.75rem
  space-lg: 1rem
  space-xl: 1.5rem
---

## Brand & Style

This design system establishes a high-density, reliable internal operations platform tailored for tour dispatchers, fleet captains, and booking coordinators in Porto de Galinhas. The visual personality communicates calm operational precision, maritime trustworthiness, and instant legibility under high-pressure ticket desks and dockside logistics.

The aesthetic follows an elevated Modern Corporate & Enterprise Utility movement—combining Bootstrap 5 structure with polished, low-friction SaaS design. The atmosphere avoids decorative consumer fluff, focusing strictly on functional data density, real-time inventory clarity, and immediate cognitive parsing of tour availability and passenger manifests.

## Colors

The palette balances coastal clarity with rigorous administrative functionalism:

- **Primary (`#0F52BA` - Sapphire Deep Navy):** Represents stability, core navigational states, primary triggers, and high-priority action buttons.
- **Secondary (`#0D9488` - Deep Teal Lagoon):** Highlights maritime sub-categories, catamarans, buggy routes, and secondary filters.
- **Canvas & Surface System:**
  - Base Application Background: `#F8F9FA` (Bootstrap light neutral canvas).
  - Component & Card Surfaces: `#FFFFFF` (Pure white).
  - Structural Hairlines & Dividers: `#DEE2E6` (Crisp separation, maintaining high visual discipline).
  - Table Row Hover / Subdued Backgrounds: `#F1F5F9`.
- **Operational Status & Capacity Indicators:**
  - **Normal / Available (< 70% occupancy):** Emerald Green (`#16A34A`), background badge `#DCFCE7`, border `#86EFAC`.
  - **Attention / Near Capacity (70% - 99% occupancy):** Amber Alert (`#D97706`), background badge `#FEF3C7`, border `#FDE68A`.
  - **Sold Out / Blocked (100% LOTADO):** Crimson Danger (`#DC2626`), background badge `#FEE2E2`, border `#FCA5A5`.
- **Text & Neutral Hierarchy:**
  - High Emphasis (Headings, primary values): `#0F172A` (Slate 900).
  - Medium Emphasis (Body, table cell data): `#334155` (Slate 700).
  - Low Emphasis (Meta labels, timestamps, field hints): `#64748B` (Slate 500).

## Typography

The type system is constructed solely using `Inter` with tabular numeral support (`tnum`) enabled across all data grids and capacity figures. This guarantees that booking counters, passenger capacities, prices (R$), and time stamps remain scannable without horizontal shifting during live data refreshes.

- **Headlines:** Kept compact (capped at 24px on desktop) to preserve viewport area for dense operations tables and schedules.
- **Body & Data Cells:** Base font size sits at 13px–14px to support high information throughput without eye strain.
- **Labels & Badges:** Upper-case and semi-bold micro-labels (11px–12px) provide immediate visual anchoring for occupancy status and tour departures.

## Layout & Spacing

This design system targets an optimized desktop baseline of **1440x900px** with fluid adaptations for field tablets (1024px) and dockside handheld screens.

- **Layout Structure:**
  - Fixed-width collapsible operations sidebar (240px wide).
  - Main operational workspace utilizing a 12-column grid with a `1.25rem` (20px) gutter.
  - Section edge margins set to `1.5rem` (24px).
- **Rhythm & Density:**
  - Component padding utilizes compact increments: `space-xs` (4px), `space-sm` (8px), and `space-md` (12px) for form inputs and table rows.
  - Cards and dashboard widgets use `space-lg` (16px) internally, keeping visual noise low while avoiding empty air.

## Elevation & Depth

Visual hierarchy is maintained through flat structural containment, low-contrast 1px outlines, and subtle ambient drop shadows rather than heavy elevation tiers.

- **Base Surface:** Level 0 canvas at `#F8F9FA` with zero elevation.
- **Panels & Operational Cards:** Level 1 elevation utilizing background `#FFFFFF`, bordered by 1px solid `#DEE2E6`, with an ambient drop shadow: `0 1px 3px rgba(15, 23, 42, 0.05)`.
- **Dropdowns, Popovers & Tide Calendars:** Level 2 elevation with a 1px border (`#DEE2E6`) and clean projection: `0 4px 12px rgba(15, 23, 42, 0.08)`.
- **Modals & Drawer Overlays (Passenger Manifests):** Level 3 elevation featuring `0 12px 28px rgba(15, 23, 42, 0.15)` paired with a soft backdrop scrim (`rgba(15, 23, 42, 0.4)`).

## Shapes

The design system adopts a calibrated soft geometric approach (`roundedness: 1`), standardizing corner radii between 6px (`0.375rem`) and 8px (`0.5rem`) across all UI elements:

- **Buttons, Form Inputs, Badges & Table Row Selectors:** 6px radius (`0.375rem`) for a clean, pragmatic corporate look that aligns with standard Bootstrap 5 utility aesthetics.
- **Cards, Filter Bars & Operational Panels:** 8px radius (`0.5rem`).
- **Pills:** Used strictly for operational status badges (Occupancy, Lotado, Confirmado) to quickly signal dynamic state changes versus static form controls.

## Components

### Buttons
- **Primary Action (Nova Reserva, Emitir Voucher):** Background `#0F52BA`, text `#FFFFFF`, border none, height 36px, horizontal padding 14px, radius 6px. Hover: `#0D47A1`. Active: `#0A387E`.
- **Secondary Action (Exportar Lista, Filtrar):** Background `#FFFFFF`, text `#334155`, 1px solid border `#DEE2E6`, height 36px. Hover: `#F8F9FA`, border `#CBD5E1`.
- **Danger (Cancelar Reserva):** Background `#FEE2E2`, text `#DC2626`, 1px solid border `#FCA5A5`.

### Occupancy & Status Badges (Pills)
- **Safe Occupancy (< 70%):** Pill format. Background `#DCFCE7`, border `#86EFAC`, text `#15803D`. Icon: subtle dot indicator or occupancy ratio (e.g., `14/30 Vagas`).
- **Warning Occupancy (70% - 99%):** Pill format. Background `#FEF3C7`, border `#FDE68A`, text `#B45309` (e.g., `26/30 Quase Lotado`).
- **Sold Out (100%):** Pill format. Background `#FEE2E2`, border `#FCA5A5`, text `#B91C1C`, bold weight (e.g., `30/30 LOTADO`).

### Form Controls & Inputs
- **Inputs & Selects:** Height 36px, background `#FFFFFF`, border 1px solid `#DEE2E6`, text `#0F172A`, placeholder `#94A3B8`, border-radius 6px, padding 6px 12px.
- **Focus State:** Border color `#0F52BA` with a soft box-shadow `0 0 0 3px rgba(15, 82, 186, 0.15)`.

### Operational Data Tables (Tours & Departures)
- **Header:** Background `#F8F9FA`, bottom border 1px solid `#DEE2E6`, typography `label-sm` uppercase, color `#64748B`.
- **Row:** Height 48px, background `#FFFFFF`, bottom border 1px solid `#F1F5F9`. Hover state switches to `#F8FAFC`.
- **Capacity Progress Mini-Bar:** Compact 4px progress rail embedded within the capacity column showing visual fill alongside numerical fractions.

### Cards & Metrics
- **Metric KPI Card:** 8px radius, 1px solid `#DEE2E6`, padding 16px. Top section displays uppercase `label-sm` label in `#64748B`, middle section contains `headline-xl` stat in tabular figures, and footer shows real-time trend or tide status (`Maré Baixa 0.2m às 10:45`).