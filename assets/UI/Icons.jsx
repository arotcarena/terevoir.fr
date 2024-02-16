import React from 'react';

export function CloseIcon(props) {
    return (
        <svg className="icon i-close" {...props} xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960">
            <path fill="currentColor" stroke="currentColor" d="m249 849-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/>
        </svg>
    )
}


export function Loader({additionnalClass, ...props}) {
    return (
        <svg className={`icon i-loader ${additionnalClass}`} {...props} xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" role="status" aria-label="Chargement en cours" aria-busy="true">
            <path fill="currentColor" stroke="currentColor" d="M480 896q-133 0-226.5-93.5T160 576q0-133 93.5-226.5T480 256q85 0 149 34.5T740 385V256h60v254H546v-60h168q-38-60-97-97t-137-37q-109 0-184.5 75.5T220 576q0 109 75.5 184.5T480 836q83 0 152-47.5T728 663h62q-29 105-115 169t-195 64Z"/>
        </svg>
    )
}

export function PhoneIcon({additionnalClass, ...props}) {
    return (
        <svg className={`icon ${additionnalClass}`} {...props}  xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" aria-hidden="true" focusable="false">
            <path fill="currentColor" stroke="currentColor" d="M795 936q-122 0-242.5-60T336 720q-96-96-156-216.5T120 261q0-19 13-32t32-13h140q14 0 24.5 9.5T343 251l27 126q2 14-.5 25.5T359 422L259 523q56 93 125.5 162T542 802l95-98q10-11 23-15.5t26-1.5l119 26q15 3 25 15t10 28v135q0 19-13 32t-32 13Z"/>
        </svg>
    )
}

export function MailIcon({additionnalClass, ...props}) {
    return (
        <svg className={`icon ${additionnalClass}`} {...props}  xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" aria-hidden="true" focusable="false">
            <path fill="currentColor" stroke="currentColor" d="M140 896q-24 0-42-18t-18-42V316q0-24 18-42t42-18h680q24 0 42 18t18 42v520q0 24-18 42t-42 18H140Zm340-302 340-223v-55L480 534 140 316v55l340 223Z"/>
        </svg>
    )
}

export function DoneIcon({additionnalClass, ...props}) {
    return (
        <svg className={`icon ${additionnalClass}`} xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" aria-hidden="true" focusable="false">
            <path fill="currentColor" stroke="currentColor" d="M378 810 154 586l43-43 181 181 384-384 43 43-427 427Z"/>
        </svg>
    )
}