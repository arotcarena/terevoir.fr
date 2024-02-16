import React, {  useState } from 'react';
import { SearchData } from '../../classes/SearchData';
import { SearchForm } from './SearchForm';
import { Success } from './Final/Success';
import { Loading } from './Final/Loading';
import { ApiError, apiFetch } from '../../functions/api';
import { Fail } from './Final/Fail';

const STATE_PENDING = 'pending';
const STATE_LOADING = 'loading';
const STATE_SUCCESS = 'success';
const STATE_FAIL = 'fail';



export function Search() {

    const [state, setState] = useState(STATE_PENDING);
    const [data, setData] = useState(null);
    const [errors, setErrors] = useState(null);

    const handleSubmitValidated = async (data) => {
        setData(data);
        setState(STATE_LOADING);
        try {
            const result = await apiFetch('/api/research', {
                method: 'POST',
                body: JSON.stringify(data)
            });
            window.scroll(0, 0);
            if(result.matchingData) {
                setData(result.matchingData);
                setState(STATE_SUCCESS);
            } else {
                setData(result.search);
                setState(STATE_FAIL);
            }
        } catch(e) {
            if(e instanceof ApiError) {
                setState(STATE_PENDING);
                setErrors(e.errors);
                return;
            }
        }
       
    }

    if(state === STATE_PENDING || state === STATE_LOADING) {
        return (
            <div className="search">
                <SearchForm onSubmitValidated={handleSubmitValidated} serverErrors={errors} />
                {
                    state === STATE_LOADING && <Loading data={data} />
                }
            </div>
        )
    }
    return (
        <div className="search">
            {
                state === STATE_SUCCESS ?  <Success data={data} /> : <Fail data={data} />
            }
        </div>
    )
    
}










