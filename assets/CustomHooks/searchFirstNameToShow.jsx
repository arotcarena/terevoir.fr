import React from 'react';

export const useSearchFirstNameToShow = searchFirstName => {
    return searchFirstName !== '' && searchFirstName.length >= 2 ? 
            <span className="capitalize">{searchFirstName}</span>: 
            <span>la personne recherchée</span>;
}