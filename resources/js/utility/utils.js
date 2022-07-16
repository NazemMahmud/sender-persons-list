// update browser URL query param
const updateQueryParam = ({queryParams, filterForm, paginationForm}) => {
    let params = {};
    if (filterForm.birthYear) {
        params['year'] = filterForm.birthYear;
    }

    if (filterForm.birthMonth) {
        params['month'] = filterForm.birthMonth;
    }

    params = {
        ...params,
        ...paginationForm
    }

    return pushParam({queryParams, params});
};

/**
 * push key value into URL query param
 * @param queryParams
 * @param params
 * @returns {*}
 */
const pushParam = ({queryParams, params}) => {
    const length =  Object.keys(params).length;

    Object.keys(params).forEach((elem, idx) => {
        queryParams = (idx && idx < length - 1) || queryParams.length ? queryParams + '&' : queryParams + '';
        queryParams += elem + '=' + params[elem];
    });

    return queryParams;
};

/**
 * after URL call, update the browser URL so that, it can be used independently
 * @param url
 * @param queryParams
 */
const updateUrl = (url, queryParams) => {
    history.pushState(
        {},
        null,
        `${url}?${queryParams}`
    );
};

export { updateQueryParam, pushParam, updateUrl };

