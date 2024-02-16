import React, { useState } from 'react';
import { Loader, MailIcon, PhoneIcon } from '../../../UI/Icons';

export function Success({data}) {

    const {firstName, email, phone, message} = data;
    const [loading, setLoading] = useState(false);

    const handleClick = () => {
        setLoading(true);
    }

    return (
        <div className="final-wrapper">
            <p className="final-title">Bonne nouvelle, {firstName} a aussi essayé de vous retrouver !</p>
            <div className="final-text-wrapper">
                <p className="final-text">Voici ses coordonnées</p>
                <div className="final-contact">
                    <div className="icon-left">
                        <MailIcon additionnalClass="i-left" />
                        <a href={`mailto:${email}`}>{email}</a>
                    </div>
                    <div className="icon-left">
                        <PhoneIcon additionnalClass="i-left" />
                        <a href={`tel:${phone}`}>{phone}</a>
                    </div>
                </div>
            </div>
            
            {
                message && (
                    <div className="final-text-wrapper">
                        <p className="final-text">Et voici le message laissé pour vous</p>
                        <div className="final-message">
                            {message}
                        </div>
                    </div>
                )
            }
            
            <div className="final-bottom">
                <p className="final-title small">Et maintenant, à vous de jouer !</p>
                <p className="final-title small">Toute l'équipe de terevoir.fr vous souhaite de belles retrouvailles !</p>
            </div>
            <div className="link-container">
                <a className="form-button message-button" href="/" onClick={handleClick}>
                {
                    loading ? <Loader /> : 'Accueil'
                }
                </a>
            </div>
        </div>
    )
}