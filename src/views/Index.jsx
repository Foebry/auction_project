import { useState, useContext, useMemo, useEffect } from "react";
import Auction from "../components/Auction";
import Categories from "../components/Categories";
import { AppContext } from "../context/AppContext";
import LoginModal from "../components/modals/LoginModal";
import RegisterModal from "../components/modals/RegisterModal";
import DetailModal from "../components/modals/DetailModal";
import UserProductsModal from "../components/modals/UserProductsModal";
import UserModal from "../components/modals/UserModal";
import EditUserModal from "../components/modals/EditUserModal";
import AdminArticleModal from "../components/modals/AdminArticleModal";
import AdminAuctionModal from "../components/modals/AdminAuctionModal";
import { useGetAuctionsQuery } from "../data/auctionAPI";
import Pagination from "../components/Pagination";
import Detailblury__modal from "../components/modals/DetailModal";

const Index = () => {
    const { modal } = useContext(AppContext);
    const [categories, setCategories] = useState([]);
    const [page, setPage] = useState(1);

    const options = useMemo(
        () => ({
            page,
            categories: categories.join(""),
            status: 0,
        }),
        [page, categories]
    );

    const { data, isError, isLoading } = useGetAuctionsQuery(options, {
        pollingInterval: 1000,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const handleFilterClick = (e) => {
        const id = e.target.id;
        const classList = e.target.classList;

        classList.toggle("categories__buttons__btn--active");

        if (categories.includes(id))
            setCategories(categories.filter((el) => el != id));
        else setCategories([...options.categories, id]);
    };

    return (
        <>
            {modal == "login" && <LoginModal />}
            {modal == "register" && <RegisterModal />}
            {modal == "user" && <UserModal />}
            {modal == "edit" && <EditUserModal />}
            {modal == "userproducts" && <UserProductsModal />}
            {modal == "articles" && <AdminArticleModal />}
            {modal == "auctions" && <AdminAuctionModal />}

            {typeof modal === "number" && <Detailblury__modal />}
            <Categories onClick={handleFilterClick} />
            <div className="container__small">
                {isLoading && <p>loading...</p>}
                {isError && <p>error...</p>}
                {data && data.auctions && (
                    <>
                        <Pagination {...{ ...data, setPage }} />
                        <ul>
                            {data.auctions.map((auction) => (
                                <Auction key={auction.id} {...auction} />
                            ))}
                        </ul>
                        {data.end - data.start > 1 && (
                            <Pagination {...{ ...data, setPage }} />
                        )}
                    </>
                )}
            </div>
        </>
    );
};

export default Index;
