import React, { useState } from 'react';
import { useSearchFirstNameToShow } from '../../../../CustomHooks/searchFirstNameToShow';
import { TextFieldWithSuggest } from '../../../../UI/Form/TextFieldWithSuggest';
import { useCitySuggestFetch } from '../../../../CustomHooks/SuggestField/citySuggestFetch';
import { PositiveNumberField } from '../../../../UI/Form/FormField';

export function SearchInfos({data, onChange, ageErrors, cityFirstErrors, cityLastErrors}) {
    

    const searchFirstName = useSearchFirstNameToShow(data.searchFirstName);

    return (
        <div className="form-block">
            <h2 className="form-block-title">Quelques infos sur {searchFirstName}</h2>
            <div className="form-group-wrapper">
                <PositiveNumberField 
                    name="searchAge" 
                    value={data.searchAge} 
                    onChange={onChange} 
                    errors={ageErrors} 
                    focus={true} 
                    maxLength={3}
                    >
                    Son âge (même approximatif) *
                </PositiveNumberField>
                <TextFieldWithSuggest 
                    useFetch={useCitySuggestFetch} 
                    name="searchCityFirst" 
                    value={data.searchCityFirst.value} 
                    onChange={onChange} 
                    errors={cityFirstErrors} 
                    additionnalClass="long-label" 
                    maxLength={200}
                    >
                    La ville de votre première rencontre
                </TextFieldWithSuggest>
                <TextFieldWithSuggest 
                    useFetch={useCitySuggestFetch}
                    name="searchCityLast" 
                    value={data.searchCityLast.value} 
                    onChange={onChange} 
                    errors={cityLastErrors} 
                    additionnalClass="long-label"
                    maxLength={200}
                    >
                    La ville de votre dernière rencontre
                </TextFieldWithSuggest>
            </div>
        </div>
    )
}