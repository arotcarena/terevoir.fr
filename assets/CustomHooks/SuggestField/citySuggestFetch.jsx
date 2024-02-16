import { useSuggestFetch } from "./suggestFetch";

export const useCitySuggestFetch = () => {
    const convertCitySuggestData = data => {
        if(data.features.length === 0) {
            return null;
        }
        return data.features.map((feature, index) => ({
                id: index,
                value: feature.properties.postcode,
                label: `${feature.properties.city} ${feature.properties.postcode}`
            }))
    }
    return useSuggestFetch('https://api-adresse.data.gouv.fr/search/?type=municipality&limit=5&q=', convertCitySuggestData);
}
