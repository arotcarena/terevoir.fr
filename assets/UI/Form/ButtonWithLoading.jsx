import React from 'react';
import { Loader } from '../Icons';

export function ButtonWithLoading({children, loading, className, type}) {
    return (
        <button className={className} disabled={loading} type={type}>
        {
            loading ? <Loader additionnalClass="button-loader" />: children
        }
        </button>
    )
}