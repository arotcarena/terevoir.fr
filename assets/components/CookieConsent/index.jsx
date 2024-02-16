import React, { useEffect, useState } from "react";
import { useCookies } from 'react-cookie';
import { createPortal } from "react-dom";
import { apiFetch } from "../../functions/api";

export const CookieConsent = () => {
    const [visible, setVisible] = useState(false);
    const [choiceDone, setChoiceDone] = useState(false);
    const [cookies, setCookie, removeCookie] = useCookies();

    useEffect(() => {
        if(cookies._trcc) {
            setChoiceDone(true);
        }
        const timeout = setTimeout(() => {
            setVisible(true);
        }, 0);
        return () => clearTimeout(timeout);
    }, []);

    const handleConsent = async () => {
        setChoiceDone(true);
        setCookie('_trcc', 'true', {maxAge: 3600 * 24 * 30 * 6}); //au bout de 6 mois on redemande le consentement de l'utilisateur
        if(cookies._tra) {
            return;
        }
        try {
            const token = await apiFetch('/api/visit/cookieConsent');
            setCookie('_tra', token, {maxAge: 3600 * 24 * 30 * 6});
        } catch(e) {
            console.error(e);
        }
    };

    const handleRefuse = async () => {
        setChoiceDone(true);
        setCookie('_trcc', 'false', {maxAge: 3600 * 24 * 30});
        if(cookies._tra) {
            removeCookie('_tra');
        }
    }

    return !choiceDone && visible &&
        createPortal(
            (
                <CookieConsentModal onConsent={handleConsent} onRefuse={handleRefuse} />
            ),
            document.body
        )
};

const CookieConsentModal = ({onConsent, onRefuse}) => {

    useEffect(() => {
        document.body.classList.add('no-scroll')
        return () => document.body.classList.remove('no-scroll');
    }, []);

    return (
        <div className="cookie-consent-modal">
            <div className="cookie-consent-wrapper" role="dialog" aria-modal="true" aria-describedby="cookie-consent-modal-body">
                <h3 className="modal-logo">terevoir.fr</h3>
                <div id="cookie-consent-modal-body" className="modal-body">
                    <p>Le site terevoir.fr utilise des cookies pour stocker et accéder à des informations sur votre appareil et traiter les données avec votre consentement.</p>
                    <p className="bold">Ces cookies permettent uniquement d'assurer le fonctionnement du site et mesurer sa fréquentation.</p>
                    <p>Vos choix sont conservés pendant 6 mois. Vous pouvez les modifier à tout moment en cliquant sur le lien « Gérer mes cookies » dans la page Conditions générales d'utilisation</p>
                    <p>Pour donner votre consentement, cliquez sur <span className="no-white-space-wrap">« accepter »</span>. Pour refuser, cliquez sur <span className="no-white-space-wrap">« continuer sans accepter »</span></p>
                </div>
                <div className="modal-footer">
                    <button className="modal-button" onClick={onConsent}>Accepter et fermer</button>
                    <button className="modal-link-button" onClick={onRefuse}>Continuer sans accepter</button>
                </div>
            </div>
        </div>
    )
}