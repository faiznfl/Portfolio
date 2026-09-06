import React from 'react';
import { createRoot } from 'react-dom/client';
import PortfolioApp from './PortfolioApp';

document.addEventListener('DOMContentLoaded', () => {
    const rootEl = document.getElementById('portfolio-app');
    if (!rootEl) return;

    let initialData = {};
    const dataScript = document.getElementById('portfolio-initial-data');
    if (dataScript) {
        try {
            initialData = JSON.parse(dataScript.textContent || '{}');
        } catch (e) {
            console.error('Gagal mengurai initial payload JSON:', e);
        }
    }

    const root = createRoot(rootEl);
    root.render(<PortfolioApp initialData={initialData} />);
});
