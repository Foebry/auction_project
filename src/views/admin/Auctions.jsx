import React, { useEffect, useMemo, useState } from "react";
import { MdTimer, MdModeEdit, MdAdd } from "react-icons/md";
import {
    TiArrowUnsorted,
    TiArrowSortedDown,
    TiArrowSortedUp,
} from "react-icons/ti";
import {
    useGetAuctionsQuery,
    useUpdateAuctionMutation,
    useUpdateAllAuctionsMutation,
} from "../../data/auctionAPI";
import Timer from "../../components/Timer";
import moment from "moment";
import Pagination from "../../components/Pagination";

const Auctions = () => {
    const [updateAuction] = useUpdateAuctionMutation();
    const [updateAllAuctions] = useUpdateAllAuctionsMutation();
    const [page, setPage] = useState(1);
    const [sort, setSort] = useState([]);
    const [options, setOptions] = useState({ page_count: 20, sort, page });

    useEffect(() => {
        setOptions({ ...options, sort, page });
    }, [sort, page]);

    const { data, isError, isLoading } = useGetAuctionsQuery(options, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const handleSort = (e) => {
        const key = e.target.dataset.sort;

        if (!sort.includes(key) && !sort.includes(`-${key}`))
            setSort([...sort, key]);
        else if (sort.includes(key))
            setSort(sort.join(",").replace(key, `-${key}`).split(","));
        else if (sort.includes(`-${key}`))
            setSort(sort.filter((el) => el !== `-${key}`));
    };

    const handleReset = async (e) => {
        const id = e.target.dataset.id;
        const auc_expiration = moment()
            .add(10, "minutes")
            .format("YYYY-MM-DD HH:mm:ss");
        const csrf = localStorage.getItem("csrf");

        if (e.target.dataset.id === "all") {
            updateAllAuctions({ auc_expiration, csrf });
        } else updateAuction({ id, auc_expiration, csrf });
    };

    const memoData = useMemo(() => {
        return data?.auctions?.map(({ id, name, expiration, highest_bid }) => {
            const expire = moment(expiration);
            const now = moment();
            const canBeReset = expire < now && !highest_bid;

            return (
                <li className="list__user" key={id}>
                    <p>{name}</p>
                    <span className="list__user__email">
                        {<Timer rest={expiration} />}
                    </span>
                    <p className="list__user__role">{highest_bid ?? 0}</p>
                    <div className="list__buttons">
                        <button className="list__buttons__button">
                            <MdModeEdit className="icon" />
                        </button>
                        <button
                            className="list__buttons__button"
                            data-id={id}
                            disabled={!canBeReset}
                            onClick={handleReset}
                        >
                            <MdTimer
                                className={`icon ${!canBeReset && "disabled"}`}
                            />
                        </button>
                    </div>
                </li>
            );
        });
    }, [data, options]);

    return (
        <section className="content" style={{ margin: "0 auto" }}>
            <div className="content__create">
                <button
                    className="list__buttons__button"
                    data-id="all"
                    onClick={handleReset}
                >
                    <MdTimer className="icon" />
                    <span>Reset depleted</span>
                </button>
                <button>
                    <div>
                        <MdAdd className="icon" />
                        <span>Toevoegen</span>
                    </div>
                </button>
            </div>
            <ul className="list">
                <li className="list__user">
                    <button
                        className="list__user__email"
                        data-sort="auc_art_id"
                        onClick={handleSort}
                    >
                        Artikel
                        {sort.includes("auc_art_id") ? (
                            <TiArrowSortedUp />
                        ) : sort.includes("-auc_art_id") ? (
                            <TiArrowSortedDown />
                        ) : (
                            <TiArrowUnsorted />
                        )}
                    </button>
                    <button
                        className="list__user__email"
                        data-sort="end"
                        onClick={handleSort}
                    >
                        Vervalt in
                        {sort.includes("end") ? (
                            <TiArrowSortedUp />
                        ) : sort.includes("-end") ? (
                            <TiArrowSortedDown />
                        ) : (
                            <TiArrowUnsorted />
                        )}
                    </button>
                    <button onClick={handleSort} data-sort="bid">
                        Hoogste bod
                        {sort.includes("bid") ? (
                            <TiArrowSortedUp />
                        ) : sort.includes("-bid") ? (
                            <TiArrowSortedDown />
                        ) : (
                            <TiArrowUnsorted />
                        )}
                    </button>
                    <p></p>
                </li>
                {isError && <p>error..</p>}
                {isLoading && <p>loading..</p>}
                {memoData}
            </ul>
            <Pagination {...{ ...data, setPage }} />
        </section>
    );
};

export default Auctions;
