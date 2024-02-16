import React, { useEffect, useState } from 'react';
import { SuggestList } from './SuggestList';
import { TextField } from './FormField';
import { CloseIcon, Loader } from '../Icons';




export function TextFieldWithSuggest({name, value, onChange, useFetch, additionnalClass, ...props}) {
    const {suggests, searchSuggests, initialize} = useFetch();
    const [loading, setLoading] = useState(false);
    const [forceLabelDown, setForceLabelDown] = useState(false);

    const handleValidate = (dataValueAttribute, newValue) => {
        onChange(name, {
            value: newValue,
            suggested: true
        });
        initialize();
    }

    useEffect(() => {
        if(value.length < 2) {
            initialize();
        }
    }, [suggests]);

    const handleChange = async (name, newValue) => {
        onChange(name, {
            value: newValue,
            suggested: false
        });
        if(newValue.length >= 2) {
            setLoading(true);
            await searchSuggests(newValue);
            setLoading(false);
        } else {
            initialize();
        }
    };

    const handleCloseClick = () => {
        onChange(name, {
            value: '',
            suggested: false
        });
        setForceLabelDown(true);
        const timeout = setTimeout(() => {
            setForceLabelDown(false);
            clearTimeout(timeout);
        })
    };

    const handleKeyDown = e => {
        if(e.key === 'Tab') {
            initialize();
        } 
    }


    return (
        <div className="suggested-form-group">
            <TextField 
                name={name} 
                value={value}
                onChange={handleChange} 
                additionnalClass={additionnalClass + ' with-closer' + (loading ? ' with-loader': '') } 
                forceLabelDown={forceLabelDown} 
                onKeyDown={handleKeyDown} 
                autocomplete="off"
                aria-expanded={suggests !== null}
                aria-controls="suggest-list"
                aria-autocomplete="list"
                aria-haspopup="listbox"
                {...props} 
                />
            {
                loading && <Loader />
            }
            {
                value.length > 0 && <CloseIcon onClick={handleCloseClick} />
            }
            {
                suggests && <SuggestList suggests={suggests} close={initialize} onValidate={handleValidate} />
            }
        </div>
    )
}



