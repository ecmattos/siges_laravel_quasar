export function getProviders (state) {
    return state.providers;
}

export const getProviderById = (state) => (index) => {
    //console.log('index: ', index);
    let provider_id = Number(index);
    //console.log('number_provider_id: ', provider_id);
    return state.providers.find(provider => provider.id === provider_id);
}