import React from 'react';
import { PositiveNumberField, TextField } from '../../../../UI/Form/FormField';

export function MyInfos({data, onChange, firstNameErrors, lastNameErrors, birthYearErrors}) {
    return (
        <div className="form-block">
            <h2 className="form-block-title">Maintenant, des infos sur vous</h2>
            <div className="form-group-wrapper">
                <TextField name="myFirstName" value={data.myFirstName} onChange={onChange} errors={firstNameErrors} focus={true} maxLength={200}>Votre prénom *</TextField>
                <TextField name="myLastName" value={data.myLastName} onChange={onChange} errors={lastNameErrors} maxLength={200}>Votre nom *</TextField>
                <PositiveNumberField name="myBirthYear" value={data.myBirthYear} onChange={onChange} errors={birthYearErrors} maxLength={4}>Votre année de naissance *</PositiveNumberField>
            </div>
        </div>
    )
}
