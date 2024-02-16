import React, { useEffect, useRef, useState } from 'react';
import { useHighLabel } from '../../CustomHooks/highLabel';
import { FormError } from './FormError';


export function TextField(props) {
    return <FormField type="text" {...props} />
}

export function NumberField(props) {
    return <FormField type="number" {...props} />
}

export function PositiveNumberField({onChange, ...props}) {
    const handleChange = (name, value) => {
        if(value.match(/^[0-9]+$/) || value === '') {
            onChange(name, value);
        }
    }
    return <TextField onChange={handleChange} {...props} />
}


function FormField({type, name, value, onChange, errors, children, focus, additionnalClass, forceLabelDown, maxLength, ...props}) {
    const { labelRef, handleFocus, handleBlur } = useHighLabel(value);

    const [lengthError, setLengthError] = useState(false);

    const inputRef = useRef();

    useEffect(() => {
        if(focus) {
            inputRef.current.focus();
        }
    }, []);

    // pour forcer la descente du label quand on utilise la croix pour vider le champ 
    // le blur est plus rapide que l'effacement de la valeur, d'où la nécessité de refaire un handleBlur, qui fera redescendre le label puisque la value est désormais ''
    useEffect(() => {
        if(forceLabelDown) {
            handleBlur();
        }
    }, [forceLabelDown]);

    const handleChange = e => {
        if(e.target.value.length > maxLength) {
            setLengthError(true);
            const timeout = setTimeout(() => {
                setLengthError(false);
                clearTimeout(timeout);
            }, 1500);
            return;
        }
        onChange(name, e.target.value);
    }

    
    return (
        <div className={'form-group' + (errors || lengthError ? ' is-invalid': '') + (additionnalClass ? (' ' + additionnalClass): '')}>
            <label ref={labelRef} className="form-label" htmlFor={name}>{children}</label>
            <input 
                ref={inputRef} 
                id={name} 
                className="form-control" 
                type={type} 
                name={name} 
                value={value} 
                onChange={handleChange} 
                onFocus={handleFocus} 
                onBlur={handleBlur} 
                maxLength={maxLength + 1} 
                aria-describedby={errors ? `${name}-error`: null}
                aria-invalid={errors ? true: null}

                {...props} 
                />
            {
                lengthError && <FormError error={`${maxLength} caractères maximum`} />
            }
            {
                errors &&
                errors.map((error, index) => <FormError id={`${name}-error`} key={index} error={error} />)
            }
        </div>
    )
};






