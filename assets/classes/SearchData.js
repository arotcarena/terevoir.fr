import { Steps } from "./Steps";
import { LengthValidator } from "./FormValidation/LengthValidator";
import { NotBlankValidator } from "./FormValidation/NotBlankValidator";
import { IsTrueValidator } from "./FormValidation/IsTrueValidator";
import { EmailValidator } from "./FormValidation/EmailValidator";
import { PhoneValidator } from "./FormValidation/PhoneValidator";
import { IsSuggestedValidator } from "./FormValidation/IsSuggestedValidator";
import { NumberValueValidator } from "./FormValidation/NumberValueValidator";

export class SearchData {
    searchFirstName = '';
    searchLastName = '';
    searchAge = '';
    searchCityFirst = {
        value: '',
        suggested: false
    };
    searchCityLast = {
        value: '',
        suggested: false
    };
    myFirstName = '';
    myLastName = '';
    myBirthYear = '';
    myEmail = '';
    myPhone = '';
    myConsent = false;
}


const year = (new Date()).getFullYear();
const maxBirhYear = year - 10;


const VALIDATORS = {
    searchFirstName: [
        new LengthValidator({min: 2, minErrorMessage: '2 caractères minimum'}),
        new NotBlankValidator('Vous devez renseigner un prénom')
    ],
    searchLastName: [
        new LengthValidator({min: 2, minErrorMessage: '2 caractères minimum'})
    ],
    searchAge: [
        new NotBlankValidator('Vous devez renseigner un âge, même approximatif'),
        new NumberValueValidator({min: 10, minErrorMessage: 'minimum 10 ans', max: 130, maxErrorMessage: '{{value}} ans, c\'est un peu beaucoup. Essayez avec un âge plausible'})
    ],
    searchCityFirst: [
        new IsSuggestedValidator('Veuillez sélectionner une ville parmis les choix proposés')
    ],
    searchCityLast: [
        new IsSuggestedValidator('Veuillez sélectionner une ville parmis les choix proposés')
    ],
    myFirstName: [
        new LengthValidator({min: 2, minErrorMessage: '2 caractères minimum'}),
        new NotBlankValidator('Vous devez renseigner votre prénom')
    ],
    myLastName: [
        new LengthValidator({min: 2, minErrorMessage: '2 caractères minimum'}),
        new NotBlankValidator('Vous devez renseigner votre nom')
    ],
    myBirthYear: [
        new NotBlankValidator('Vous devez renseigner votre année de naissance'),
        new NumberValueValidator({min: 1900, minErrorMessage: 'Il est peu probable que vous soyez né en {{value}}', max: maxBirhYear, maxErrorMessage: 'Vous devez être né avant '+maxBirhYear+' pour utiliser ce service'})
    ],
    myEmail: [
        new EmailValidator('Adresse email invalide'),
        new NotBlankValidator('Vous devez renseigner votre email')
    ],
    myPhone: [
        new PhoneValidator('Numéro de téléphone invalide')
    ],
    myConsent: [
        new IsTrueValidator('Vous devez cochez cette case'),
    ]
}


/**
 * @param {SearchData} data 
 * @param {string|number} step 
 * 
 */
export function validateSearch(data, step) {
    let toValidate = [];

    if(step >= Steps.SEARCH_NAME) {
        toValidate.push('searchFirstName');
        toValidate.push('searchLastName');
    } 
    if(step >= Steps.SEARCH_INFOS) {
        toValidate.push('searchAge');
        toValidate.push('searchCityFirst');
        toValidate.push('searchCityLast');
    }
    if(step >= Steps.MY_INFOS) {
        toValidate.push('myFirstName');
        toValidate.push('myLastName');
        toValidate.push('myBirthYear');
    }
    if(step >= Steps.MY_CONTACT) {
        toValidate.push('myEmail');
        toValidate.push('myPhone');
        toValidate.push('myConsent');
    }

    const errors = {};
    for(const field of toValidate) {
        if(VALIDATORS[field]) {
            for(const validator of VALIDATORS[field]) {
                const errorMessage = validator.validate(data[field]);
                if(errorMessage) {
                    if(errors[field]) {
                        errors[field].push(errorMessage)
                    } else {
                        errors[field] = [errorMessage];
                    }
                }
            }
        }
    }
    return errors;
}