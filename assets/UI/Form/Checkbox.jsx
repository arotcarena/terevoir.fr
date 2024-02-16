import React, { useState } from 'react';
import { FormError } from './FormError';

export function Checkbox({name, value, onChange, errors, children}) {

    const [focus, setFocus] = useState(false);

    const handleKeyDown = e => {
        if(e.key === 'Enter') {
            e.preventDefault();
            onChange(name, !value);
        }
    }

    const handleChange = e => {
        onChange(name, e.target.checked);
    }

    const handleFocus = () => {
        setFocus(true);
    }
    const handleBlur = () => {
        setFocus(false);
    }


    return (
        <div className={'form-group checkbox-group' + (errors ? ' is-invalid': '')}>
            <label className="form-label checkbox-label" htmlFor={name}>
                <div className={'checkbox' + (value ? ' checked': '') + (focus ? ' focus': '')}>
                    {
                        value && (
                            <svg className="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960">
                                <path fill="currentColor" stroke="currentColor" d="M378 831 133 586l66-66 179 180 382-382 66 65-448 448Z"/>
                            </svg>
                        )
                    }
                </div>
                <input 
                    id={name} 
                    className="form-checkbox"
                    type="checkbox" 
                    name={name} 
                    checked={value} 
                    onChange={handleChange} 
                    placeholder={children}
                    onFocus={handleFocus} 
                    onBlur={handleBlur} 
                    onKeyDown={handleKeyDown} 
                    />
                <span>{children}</span>
            </label>
            {
                errors &&
                errors.map((error, index) => <FormError key={index} error={error} />)
            }
        </div>
    )
}
