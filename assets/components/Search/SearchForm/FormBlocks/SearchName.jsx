import React, { memo } from "react";
import { TextField } from "../../../../UI/Form/FormField";



export const SearchName = memo(({searchFirstName, searchLastName, onChange, firstNameErrors, lastNameErrors}) => {
   
    return (
        <div className="form-block">
            <h2 className="form-block-title">Qui recherchez vous ?</h2>
            <div className="form-group-wrapper">
                <TextField name="searchFirstName" value={searchFirstName} onChange={onChange} errors={firstNameErrors} focus={true} maxLength={200}>Son prénom *</TextField>
                <TextField name="searchLastName" value={searchLastName} onChange={onChange} errors={lastNameErrors} maxLength={200}>Son nom</TextField>
            </div>
        </div>
    )
});