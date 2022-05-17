import React from "react";
import { useGetAuctionsQuery } from "../data/auctionAPI";

const ReduxTest = () => {
    const { data, isLoading, isError } = useGetAuctionsQuery();
    console.log(data);
    return (
        <>
            {isLoading && <p>Loading...</p>}
            {isError && <p>Error...</p>}
            <ul>
                {data &&
                    data.map(({ id, name }) => {
                        return <li key={id}>{name}</li>;
                    })}
            </ul>
        </>
    );
};

export default ReduxTest;
