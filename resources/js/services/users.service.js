import {instance as axios} from "../utility/axios";

/**
 * Get users data in a list
 * @returns {Promise<AxiosResponse<any>>}
 */
export const getUsersList = async (params) => {
    params = '?' + params;
    return axios.get(`users${params}`);
};



/**
 * Get the original URL
 *
 * @param hashCode
 * @returns {Promise<AxiosResponse<any>>}
 */
export const getOriginalUrl = async hashCode => {
    return axios.get(`url-shorten/get-url/${hashCode}`);
};
