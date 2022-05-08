import {useEffect, useState} from "react";
import Auction from "../components/Auction";
import Categories from "../components/Categories";
import { currentAuctions } from "../mocks/auctions.js";
import axios from 'axios';

const Index = () => {
    const [activeFilter, setActiveFilter] = useState([]);

    useEffect(()=>{
        (async ()=>{
            const data = await axios("http://localhost:8000/api/auctions");
            console.log(data);
        })();
    },[])

    const handleFilterClick = (e) => {
        const id = e.target.id;
        const classList = e.target.classList;

        classList.toggle("categories__buttons__btn--active");

        if (activeFilter.includes(id)) {
            setActiveFilter(filter.filter((item) => item != id));
        } else {
            setActiveFilter([...filter, id]);
        }
    };
    return (
        <>
            <Categories onClick={handleFilterClick} />
            <div className="container__small">
                {currentAuctions.map((auction) => (
                    <Auction key={auction.id} {...auction} />
                ))}
            </div>
        </>
    );
};

export default Index;
