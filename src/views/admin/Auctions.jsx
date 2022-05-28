import React, { useMemo, useState } from "react";
import { MdTimer, MdModeEdit, MdAdd } from "react-icons/md";
import { useGetAuctionsQuery } from "../../data/auctionAPI";
import ConfirmationModal from "../../components/modals/messageModals/ConfirmationModal";
import Timer from "../../components/Timer";

const Auctions = () => {
    const [nameFilter, setNameFilter] = useState("");
    const [confirm, setConfirm] = useState(false);
    const [userToDelete, setUserToDelete] = useState();
    const [options, setOptions] = useState({ page_count: 100, sort: {} });

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

    const confirmDelete = (e) => {
        setUserToDelete(e.target.dataset.id);
        setConfirm(true);
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

    const memoData = useMemo(() => {
        return data?.auctions
            ?.filter((el) =>
                el.name.toLowerCase().includes(nameFilter.toLowerCase())
            )
            .map(({ id, name, expiration, highest_bid }) => {
                const canBeReset = false;

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
                            >
                                <MdTimer className="icon" />
                            </button>
                        </div>
                    </li>
                );
            });
    }, [data, nameFilter]);

    return (
        <section className="content" style={{ margin: "0 auto" }}>
            <div className="content__create">
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
            <ConfirmationModal
                isShown={confirm}
                primaryAction="Delete"
                secondaryAction="Cancel"
                message={"Delete User"}
                onPrimaryAction={handleDelete}
                onSecondaryAction={() => setConfirm(false)}
                onCancel={() => setConfirm(false)}
            ></ConfirmationModal>
        </section>
    );
};

export default Auctions;
