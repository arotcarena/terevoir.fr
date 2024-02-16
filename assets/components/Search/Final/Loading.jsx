import React, { useEffect } from 'react';
import { createPortal } from 'react-dom';
import { Loader } from '../../../UI/Icons';
import { useSearchFirstNameToShow } from '../../../CustomHooks/searchFirstNameToShow';

export function Loading({data}) {

    const searchFirstName = useSearchFirstNameToShow(data.searchFirstName);

    useEffect(() => {
        document.body.classList.add('no-scroll');
        return () => document.body.classList.remove('no-scroll');
    }, []);

    return (
        createPortal(
            <div className="loading-page">
                <div className="loading-center">
                    <h1 className="loading-text">Veuillez patienter quelques instants, Nous recherchons { searchFirstName }</h1>
                    <Loader additionnalClass="loader-big" />
                </div>
            </div>,
            document.body
        )
    )
}