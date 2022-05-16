import { useState, useContext } from "react";
import Auction from "../components/Auction";
import Categories from "../components/Categories";
import { AppContext } from "../context/AppContext";
import { currentAuctions } from "../mocks/auctions.js";
import LoginModal from "../components/modals/LoginModal";
import RegisterModal from "../components/modals/RegisterModal";
import DetailModal from "../components/modals/DetailModal";
import ReduxTest from "../components/ReduxTest";

const Index = () => {
    const [activeFilter, setActiveFilter] = useState([]);
    const { modal } = useContext(AppContext);

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
            {modal == "login" && <LoginModal />}
            {modal == "register" && <RegisterModal />}

            {typeof modal == "number" && <DetailModal />}
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
