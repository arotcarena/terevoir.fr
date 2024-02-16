import React, { useEffect, useState } from 'react';

export function SuggestList({suggests, close, onValidate}) {

    const [selected, setSelected] = useState(null);


    useEffect(() => {
        document.addEventListener('click', close);
        return () => document.removeEventListener('click', close);
    }, []);

    useEffect(() => {
        const onKeyDown = e => {
            switch(e.key) {
                case 'ArrowUp':
                    e.preventDefault();
                    setSelected(selected => {
                        if(selected === null || selected <= 0) {
                            return (suggests.length - 1);
                        }
                        return (selected - 1);
                    });
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    setSelected(selected => {
                        if(selected === null || selected >= (suggests.length - 1)) {
                            return 0;
                        }
                        return (selected + 1);
                    });
                    break;
                default: 
                    break;
            }
        }
        document.addEventListener('keydown', onKeyDown);
        return () => document.removeEventListener('keydown', onKeyDown);
    }, []);

    useEffect(() => {
        const onKeyDown = e => {
           if(e.key === 'Enter') {
                e.preventDefault();
                onValidate(
                    suggests[selected].value,
                    suggests[selected].label
                );
           }
        }
        document.addEventListener('keydown', onKeyDown);
        return () => document.removeEventListener('keydown', onKeyDown);
    }, [selected]);

    return (
        <ul id="suggest-list" className="suggest-list" onClick={e => e.stopPropagation()} role="listbox" aria-label="Suggestions">
        {
            suggests && 
            suggests.map((suggest, index) => (
                <SuggestItem key={suggest.id} value={suggest.value} onValidate={onValidate} selected={selected === index}>
                    {suggest.label}
                </SuggestItem>
            ))
        }
        </ul>
    )
}



export function SuggestItem({value, children, onValidate, selected}) {
    
    const handleClick = e => {
        onValidate(value, children);
    }
    
    return (
        <li className={'suggest-item' + (selected ? ' selected': '')} data-value={value} onClick={handleClick} role="option" aria-selected={selected}>
            {children}
        </li>
    )
}
