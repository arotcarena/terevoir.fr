import React, { useEffect, useRef, useState } from 'react';
import { FormError } from './FormError';

export function TextArea({name, value, onChange, errors, children, focus, additionnalClass, maxLength, ...props}) {

    const [lengthError, setLengthError] = useState(false);

    const inputRef = useRef();

    useEffect(() => {
        if(focus) {
            inputRef.current.focus();
        }
    }, []);

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
        <div className={'form-group textarea-group' + (errors || lengthError ? ' is-invalid': '')}>
            <textarea 
                ref={inputRef} 
                id={name} 
                className={`form-textarea ${additionnalClass}`} 
                name={name} 
                value={value} 
                onChange={handleChange} 
                placeholder={children} 
                maxLength={maxLength + 1} 
                aria-describedby={`${name}-error`}
                aria-invalid={errors !== undefined}
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
}
