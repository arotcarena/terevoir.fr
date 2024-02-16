import React, { useState } from 'react';
import { useSearchFirstNameToShow } from '../../../CustomHooks/searchFirstNameToShow';
import { TextArea } from '../../../UI/Form/Textarea';
import { ApiError, apiFetch } from '../../../functions/api';
import { ButtonWithLoading } from '../../../UI/Form/ButtonWithLoading';
import { FormError } from '../../../UI/Form/FormError';
import { DoneIcon, Loader } from '../../../UI/Icons';

const STATE_PENDING = 'pending';
const STATE_LOADING = 'loading';
const STATE_SENT_SUCCESS = 'sent';


/**
 * 
 * @param {object} data {id: , firstName: } 
 * @returns 
 */
export function Fail({data}) {

    const [state, setState] = useState(STATE_PENDING);
    const [message, setMessage] = useState('');
    const [errors, setErrors] = useState(null);

    const handleChangeMessage = (name, newValue) => {
        setMessage(newValue);
    }

    const handleSubmit = async e => {
        e.preventDefault();
        if(state === STATE_LOADING) {
            return;
        }
        setErrors(null);
        setState(STATE_LOADING);
        try {
            await apiFetch('/api/persistMessage/'+data.id, {
                method: 'POST',
                body: JSON.stringify(message)
            }); 
            setState(STATE_SENT_SUCCESS);
        } catch(e) {
            setState(STATE_PENDING);
            if(e instanceof ApiError) {
                setErrors(e.errors.message);
                return;
            }
            setErrors(['Le message n\'a pas pu être sauvegardé. Veuillez réessayer plus tard ou passer cette étape']);
        }
    }

    const searchFirstName = useSearchFirstNameToShow(data.firstName);

    return (
        <div className="final-wrapper">
            {
                state !== STATE_SENT_SUCCESS 
                ?
                <MessageForm searchFirstName={searchFirstName} onSubmit={handleSubmit} onChange={handleChangeMessage} message={message} state={state} errors={errors}/>
                :
                <MessageShow message={message} searchFirstName={searchFirstName} />
            }
        </div>
    )
}




function MessageForm({searchFirstName, onSubmit, onChange, message, state, errors}) {
    return (
        <>
            <p className="final-title">Nous sommes désolés, aucune trace de {searchFirstName}...</p>
            <div className="final-text-wrapper">
                <p className="final-text">Soit {searchFirstName} n'a pas encore tenté de vous retrouver via notre site, soit certaines informations que vous avez saisies sont incorrectes.</p>
                <p className="final-text">Vous pouvez tout de même lui laisser un message, que {searchFirstName} pourra voir uniquement le jour où il/elle vous recherchera</p>
            </div>
            <form className="message-block" onSubmit={onSubmit}>
                <TextArea name="message" value={message} onChange={onChange} maxLength={2000} errors={errors} additionnalClass={"message-textarea"} cols="30" rows="5">
                    Entrez votre message ici...
                </TextArea>
                {
                    state === STATE_LOADING && (
                        <div className="sent-info">
                            <div className="info-message">
                                { message !== '' ? 'Sauvegarde du message en cours...': 'Mise à jour des informations...' }
                            </div>
                        </div>
                    )
                }
                <ButtonWithLoading loading={state === STATE_LOADING} className="form-button message-button" type="submit">
                    {message !== '' ? 'Valider': 'Passer'}
                </ButtonWithLoading>
            </form>
        </>
    )
}

function MessageShow({message, searchFirstName}) {
    const [loading, setLoading] = useState(false);

    const handleClick = () => {
        setLoading(true);
    };

    return (
        <>
            <p className="final-title">C'est terminé !</p>
            <div className="message-block">
                <div className="form-group textarea-group">
                {
                    message !== '' && 
                        (
                            <>
                                <p className="final-text">Votre message</p>
                                <div className="message-textarea center">{message}</div>
                            </>
                        )
                }
                </div>
                <div className="sent-info">
                    <div className="success-message">
                        <DoneIcon />
                        <span>
                            { message !== '' ? 'Votre message et vos': 'Vos' } coordonnées ont été sauvegardées dans notre base de données. Nous les afficherons à {searchFirstName} lorsqu'il/elle tentera à son tour de vous retrouver
                        </span>
                    </div>
                </div>
                <div className="link-container">
                    <a className="form-button message-button" href="/" onClick={handleClick}>
                    {
                        loading ? <Loader /> : 'Accueil'
                    }
                    </a>
                </div>
            </div>
        </>
    )
}