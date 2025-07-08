import '../css/app.css';
import './bootstrap';

import { router } from '@inertiajs/react'

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.tsx`,
            import.meta.glob('./Pages/**/*.tsx'),
        ),
    setup({ el, App, props }) {
        router.on('before', event => {
            let token = null
            if (token = Cookies.get('auth_token')) {
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            } else if (event.detail.visit.url.pathname != '/login') {
                router.visit('login')
            }
        })

        const root = createRoot(el);

        root.render(<App {...props} />);       
    },
    progress: {
        color: '#4B5563',
    },
});
