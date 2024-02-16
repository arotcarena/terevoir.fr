/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import {createRoot} from 'react-dom/client';
import React from 'react';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import { Search } from './components/Search';
import { CookieConsent } from './components/CookieConsent';


const cookieConsentRoot = createRoot(document.getElementById('cookie-consent'));
cookieConsentRoot.render(<CookieConsent />);

if(document.getElementById('search')) {
    const root = createRoot(document.getElementById('search'));
    root.render(<Search />)
}



