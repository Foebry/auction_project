import { useState, useContext } from "react";
import Auction from "../components/Auction";
import Categories from "../components/Categories";
import { AppContext } from "../context/AppContext";
import LoginModal from "../components/modals/LoginModal";
import RegisterModal from "../components/modals/RegisterModal";
import UserModal from "../components/modals/UserModal";
import EditUserModal from "../components/modals/EditUserModal";
import DetailModal from "../components/modals/DetailModal";
import { useGetAuctionsQuery } from "../data/auctionAPI";

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
    const { data, isError, isLoading } = useGetAuctionsQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });
    return (
        <>
            {modal == "login" && <LoginModal />}
            {modal == "register" && <RegisterModal />}
            {modal == "user" && <UserModal />}
            {modal == "edit" && <EditUserModal />}

            {typeof modal == "number" && <DetailModal />}
            <Categories onClick={handleFilterClick} />
            <div className="container__small">
                {isLoading && <p>loading...</p>}
                {isError && <p>error...</p>}
                {data && data.auctions && (
                    <ul>
                        {data.auctions.map((auction) => (
                            <Auction key={auction.id} {...auction} />
                        ))}
                    </ul>
                )}
            </div>
        </>
    );
};

export default Index;
