import '../css/app.css';
import './bootstrap';
import React from 'react';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import IncidentTable from "./components/IncidentTable";
import ReporterInfoTable from "./components/ReporterInfoTable";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

const App = () => {
    return (
      <div className="container mx-auto mt-8">
        <h1 className="text-3xl font-bold text-center text-white mb-4 border-1 border-blackpurple bg-gray-800 px-4 py-2 rounded-lg">
          Admin Incident Reports
        </h1>
        <IncidentTable />
        <h1 className="text-3xl font-bold text-center text-white mb-4 border-1 border-blackpurple bg-gray-800 px-4 py-2 rounded-lg">
          Reporter Info
        </h1>
        <ReporterInfoTable />
      </div>
    );
  };
  
  const root = createRoot(document.getElementById("app"));
  root.render(<App />);