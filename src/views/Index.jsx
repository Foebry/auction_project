import { useState, useContext, useMemo } from "react";
import Auction from "../components/Auction";
import Categories from "../components/Categories";
import { AppContext } from "../context/AppContext";
import LoginModal from "../components/modals/LoginModal";
import RegisterModal from "../components/modals/RegisterModal";
import DetailModal from "../components/modals/DetailModal";
import { useGetAuctionsQuery } from "../data/auctionAPI";
import Pagination from "../components/Pagination";

const Index = () => {
    const { modal } = useContext(AppContext);
    const [filter, setFilter] = useState([]);

    const { data, isError, isLoading } = useGetAuctionsQuery(
        filter,
        {
            pollingInterval: 1000,
            refetchOnFocus: true,
            refetchOnReconnect: true,
        },
        [filter]
    );

    const options = useMemo(
        () => ({
            page: data?.page,
            filter: filter.join(","),
        }),
        [data]
    );

    const handleFilterClick = (e) => {
        const id = e.target.id;
        const classList = e.target.classList;

        classList.toggle("categories__buttons__btn--active");

        if (filter.includes(id)) setFilter(filter.filter((el) => el != id));
        else setFilter([...options.filter, id]);
    };

    return (
        <>
            {modal == "login" && <LoginModal />}
            {modal == "register" && <RegisterModal />}

            {typeof modal == "number" && <DetailModal />}
            <Categories onClick={handleFilterClick} />
            <div className="container__small">
                {isLoading && <p>loading...</p>}
                {isError && <p>error...</p>}
                {data && data.auctions && (
                    <>
                        <Pagination {...data} />
                        <ul>
                            {data.auctions.map((auction) => (
                                <Auction key={auction.id} {...auction} />
                            ))}
                        </ul>
                        <Pagination {...data} />
                    </>
                )}
            </div>
        </>
    );
};

export default Index;
