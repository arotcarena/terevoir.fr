import { useRef } from "react";

export const useHighLabel = value => {
    const labelRef = useRef(null);
    const handleFocus = e => {
        labelRef.current.classList.add('high');
    }
    const handleBlur = e => {
        if(value === '') {
            labelRef.current.classList.remove('high');
        }
    }

    return { labelRef, handleFocus, handleBlur };
}