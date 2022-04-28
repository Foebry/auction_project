import React from "react";
import Auction from "../components/Auction";
import Categories from "../components/Categories";
import Timer from "../components/Timer";
import { currentAutcions } from "../mocks/auctions.js";

const Index = () => {
    return (
        <>
            <Categories />
            {currentAutcions.map((auction) => (
                <Auction key={auction.id} {...auction} />
            ))}
        </>
    );
};

export default Index;
