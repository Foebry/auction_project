import React, { useMemo, useState } from "react";
import { MdTimer, MdModeEdit, MdAdd } from "react-icons/md";
import {
    useGetAuctionsQuery,
    useUpdateAuctionMutation,
    useUpdateAllAuctionsMutation,
} from "../../data/auctionAPI";
import ConfirmationModal from "../../components/modals/messageModals/ConfirmationModal";
import Timer from "../../components/Timer";
import moment from "moment";

const Auctions = () => {
    const [updateAuction] = useUpdateAuctionMutation();
    const [updateAllAuctions] = useUpdateAllAuctionsMutation();
    const [nameFilter, setNameFilter] = useState("");
    const [confirm, setConfirm] = useState(false);
    const [userToDelete, setUserToDelete] = useState();
    const [options, setOptions] = useState({ page_count: 20, sort: {} });

    const { data, isError, isLoading } = useGetAuctionsQuery(options, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const handleBidSort = (e) => {
        const sort = e.target.dataset.sort;
        if (options.sort?.[sort] === undefined) {
        }
    };

    const handleDelete = async () => {
        const { data, error } = await deleteUser(userToDelete);

        if (error) {
            console.log(error);
        } else if (data) {
            setConfirm(false);
            setUserToDelete(undefined);
        }
    };

    const handleReset = async (e) => {
        console.log(e.target);
        const id = e.target.dataset.id;
        const auc_expiration = moment()
            .add(10, "minutes")
            .format("YYYY-MM-DD HH:mm:ss");
        const csrf = localStorage.getItem("csrf");

        if (e.target.dataset.id === "all") {
            console.log("resetting all depleted auctions");
            updateAllAuctions({ auc_expiration, csrf });
        } else updateAuction({ id, auc_expiration, csrf });
    };

    const memoData = useMemo(() => {
        return data?.auctions
            ?.filter((el) =>
                el.name.toLowerCase().includes(nameFilter.toLowerCase())
            )
            .map(({ id, name, expiration, highest_bid }) => {
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
                                    className={`icon ${
                                        !canBeReset && "disabled"
                                    }`}
                                />
                            </button>
                        </div>
                    </li>
                );
            });
    }, [data, nameFilter]);

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
                    <p>Artikel</p>
                    <p className="list__user__email">Vervalt in</p>
                    <span onClick={handleBidSort} data-sort="bid">
                        Hoogste bod
                    </span>
                    <p></p>
                </li>
                {isError && <p>error..</p>}
                {isLoading && <p>loading..</p>}
                {memoData}
            </ul>
        </section>
    );
};

export default Auctions;
