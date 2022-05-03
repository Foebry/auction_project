import React from "react";
import Auction from "../components/Auction";
import Categories from "../components/Categories";
import Login from "../components/Login";
import Timer from "../components/Timer";
import { currentAutcions } from "../mocks/auctions.js";

const Index = () => {
    return (
        <>
            <Categories />
            <div className="container__small">
                {currentAutcions.map((auction) => (
                    <Auction key={auction.id} {...auction} />
                ))}
            </div>
        </>
    );
};

export default Index;
