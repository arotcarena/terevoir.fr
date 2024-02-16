import React from 'react';
import { useHighLabel } from '../../CustomHooks/highLabel';
import { FormError } from './FormError';


export const PhoneField = ({name, value, onChange, errors, children, additionnalClass, forceLabelDown}) => {
    const { labelRef, handleFocus, handleBlur } = useHighLabel(value);

    const handleKeyDown = e => {
        const key = e.key;
        if(key === 'Backspace') {
            if(value.at(-1) === ' ') {
                onChange(name, value.slice(0, -2));
            } else {
                onChange(name, value.slice(0, -1));
            }
        } else {
            if(!e.key.match(/\d+/)) {
                return;
            } 
            if(value.length >= 14) {
                return;
            }
            if([1, 4, 7, 10].includes(value.length)) {
                onChange(name, value + key + ' ');
            } else{
                onChange(name, value + key);
            }
        }
    }


    return (
        <div className={'form-group' + (errors ? ' is-invalid': '') + (additionnalClass ? (' ' + additionnalClass): '')}>
            <label ref={labelRef} className="form-label" htmlFor={name}>{children}</label>
            <input id={name} className="form-control" type="text" name={name} value={value} onChange={() => {}} onKeyDown={handleKeyDown} onFocus={handleFocus} onBlur={handleBlur} />
            {
                errors &&
                errors.map((error, index) => <FormError key={index} error={error} />)
            }
        </div>
    )
};