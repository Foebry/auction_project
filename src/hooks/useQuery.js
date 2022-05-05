import axios from "axios";
import { useEffect, useState } from "react";

export const useQuery = (endpoint, options) => {

    const [error, setError] = useState(false);
    const [loading, setLoading] = useState(true);
    const [data, setData] = useState([]);
    const [queryOptions, setQueryOptions] = useState(options);

    const executeQuery = async (endpoint, opts={}) => {
        setQueryOptions(opts);
        console.log(opts);
        setLoading(true);
        setError(false);
        try{
            const { data } = await axios(endpoint);
            setLoading(false);
            setError(false);
            setData(data);
        }catch(error) {
            setLoading(false);
            setError(error);
            setData([]);
        }
    }

    useEffect(() => {
        executeQuery(endpoint, options);
    }, []);

    const refetch = async (newOptions) => {
        const opts = newOptions? {...queryOptions, ...newOptions} : queryOptions
        await executeQuery(endpoint, opts);
    }

    return {loading, error, data, refetch}
} 