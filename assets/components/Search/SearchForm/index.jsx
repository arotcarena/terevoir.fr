import React, { useState, useCallback, useEffect } from 'react';
import { SearchInfos } from './FormBlocks/SearchInfos';
import { MyInfos } from './FormBlocks/MyInfos';
import { MyContact } from './FormBlocks/MyContact';
import { SearchName } from './FormBlocks/SearchName';
import { Steps } from '../../../classes/Steps';
import { SearchData, validateSearch } from '../../../classes/SearchData';
import { FormError } from '../../../UI/Form/FormError';
import { Loader } from '../../../UI/Icons';



export function SearchForm({onSubmitValidated, serverErrors}) {

    const [step, setStep] = useState(Steps.SEARCH_NAME);
    const [data, setData] = useState(new SearchData());
    const [errors, setErrors] = useState(null);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        setErrors(serverErrors);
    }, [serverErrors]);

    const handleSubmit = async e => {
        e.preventDefault();
        const submitErrors = validateSearch(data, step);
        if(Object.values(submitErrors).length > 0) {
            setErrors(submitErrors);
        } else {
            setErrors(null);
            if(step >= Steps.MY_CONTACT) {
                setLoading(true);
                await onSubmitValidated(data);
                setLoading(false);
                return;
            }
            setStep(step => step + 1);
        }
    }

    const handleChange = useCallback((name, value) => {
        setData(data => ({
            ...data,
            [name]: value
        }));
    });



    let mainError = null;
    if(errors) {
        if(errors.main) {
            mainError = errors.main.map((error, index) => <FormError key={index} error={error} additionnalClass="form-error-big" />) 
        } else {
            mainError = <FormError id="search-form-error" error="Le formulaire comporte des erreurs" additionnalClass="form-error-big" />
        }
    }
    

    return (
        <form 
            className="search-form" 
            onSubmit={handleSubmit}
            >
            <SearchName 
                searchFirstName={data.searchFirstName} 
                searchLastName={data.searchLastName} 
                onChange={handleChange} 
                firstNameErrors={errors?.searchFirstName} 
                lastNameErrors={errors?.searchLastName} 
                />
            {
                step >= Steps.SEARCH_INFOS && 
                <SearchInfos 
                    data={data} 
                    onChange={handleChange} 
                    ageErrors={errors?.searchAge} 
                    cityFirstErrors={errors?.searchCityFirst} 
                    cityLastErrors={errors?.searchCityLast} 
                    />
            }
            {
                step >= Steps.MY_INFOS && 
                <MyInfos 
                    data={data} 
                    onChange={handleChange} 
                    firstNameErrors={errors?.myFirstName} 
                    lastNameErrors={errors?.myLastName} 
                    birthYearErrors={errors?.myBirthYear} 
                    />
            }
            {
                step >= Steps.MY_CONTACT && 
                <MyContact 
                    data={data} 
                    onChange={handleChange} 
                    emailErrors={errors?.myEmail} 
                    phoneErrors={errors?.myPhone} 
                    consentErrors={errors?.myConsent} 
                    />
            }

            {
                mainError
            }

            <button className="form-button no-fix-width" type="submit">
                {
                    loading 
                    ? 
                    <Loader />
                    :
                    (
                        <span>
                            { step === Steps.MY_CONTACT ? 'Lancer la recherche': 'Valider' }
                        </span>
                    )
                }
            </button>
        </form>
    )
}