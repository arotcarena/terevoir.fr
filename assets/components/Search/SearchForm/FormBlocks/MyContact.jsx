import React from 'react';
import { useSearchFirstNameToShow } from '../../../../CustomHooks/searchFirstNameToShow';
import { TextField } from '../../../../UI/Form/FormField';
import { Checkbox } from '../../../../UI/Form/Checkbox';
import { PhoneField } from '../../../../UI/Form/PhoneField';




export function MyContact({data, onChange, emailErrors, phoneErrors, consentErrors}) {
    
    const searchFirstName = useSearchFirstNameToShow(data.searchFirstName);

    return (
        <div className="form-block">
            <h2 className="form-block-title nospace-bottom">C'est presque fini</h2>
            <p className="form-block-text">
                Laissez vos coordonnées, la personne que vous recherchez les verra uniquement si elle vous a aussi recherché.
            </p>
            <div className="form-group-wrapper">
                <TextField name="myEmail" value={data.myEmail} onChange={onChange} errors={emailErrors} focus={true} maxLength={200}>Adresse email *</TextField>
                <PhoneField name="myPhone" value={data.myPhone} onChange={onChange} errors={phoneErrors}>Téléphone</PhoneField>
                <Checkbox name="myConsent" value={data.myConsent} onChange={onChange} errors={consentErrors}>
                    J'accepte les <a className="consent-link" href="/conditions-générales-d-utilisation" target="_blank" rel="noopener noreferrer">Conditions générales d'utilisation</a> *
                </Checkbox>
            </div>
        </div>
    )
}