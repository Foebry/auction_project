import { useState, useMemo } from "react";
import Auction from "../components/Auction";
import Categories from "../components/Categories";
import { useGetAuctionsQuery } from "../data/auctionAPI";
import Pagination from "../components/Pagination";

const Index = () => {
    const [categories, setCategories] = useState([]);
    const [page, setPage] = useState(1);

    const { data, isError, isLoading } = useGetAuctionsQuery(
        { categories: categories.join(","), page },
        {
            pollingInterval: 1000,
            refetchOnFocus: true,
            refetchOnReconnect: true,
        }
    );

    const options = useMemo(
        () => ({
            page,
            categories: categories.join(""),
        }),
        [data, page, categories]
    );

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
