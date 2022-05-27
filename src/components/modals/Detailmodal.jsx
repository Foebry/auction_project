import Timer from "../Timer";
import { RiCoinLine } from "react-icons/ri";
import BaseModal from "./baseModal";
import { useContext, useState } from "react";
import { AppContext } from "../../context/AppContext";
import { useGetAuctionByIdQuery } from "../../data/auctionAPI.js";
import { usePostBiddingsMutation } from "../../data/biddingAPI";

const Detailblury__modal = () => {
    const { modal, handleLogout, setModal } = useContext(AppContext);

    const [bid, setBid] = useState("");
    const { data, isError, isLoading } = useGetAuctionByIdQuery(modal, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const [postBidding] = usePostBiddingsMutation();

    const handleFastBid = (e) => {
        const amount = parseInt(e.currentTarget.dataset.bid);
        const maxBid = Math.max(
            ...data?.biddings.map((bidding) => bidding.bid)
        );

        setBid(maxBid + amount);
    };
    const onSubmit = async (e) => {
        e.preventDefault();
        const { data: response, error } = await postBidding({
            bid_price: bid,
            bid_auc_id: data?.id,
        });

        if (error?.status === 403) {
            await handleLogout();
        } else if (response) setBid("");
    };
    const handleBidChange = (e) => {
        setBid(e.target.value);
    };

    return (
        <BaseModal>
            <div className="modal__title">{data && <h2>{data.name}</h2>}</div>
            <Timer rest={data && data.expiration} />
            <div className="modal__bidding">
                <p className="modal__bidding__text">Bet fast:</p>
                <div className="modal__bidding__fast">
                    <button
                        className="modal__bidding__fast__btn"
                        onClick={handleFastBid}
                        data-bid="1"
                    >
                        <p className="modal__bidding__btn__text">+1 €</p>
                    </button>
                    <button
                        className="modal__bidding__fast__btn"
                        onClick={handleFastBid}
                        data-bid="2"
                    >
                        <p className="modal__bidding__fast__btn__text">+2 €</p>
                    </button>
                    <button
                        className="modal__bidding__fast__btn"
                        onClick={handleFastBid}
                        data-bid="5"
                    >
                        <p className="modal__bidding__btn__text">+5 €</p>
                    </button>
                </div>
                <form className="modal__bidding__input" onSubmit={onSubmit}>
                    <input
                        className="modal__bidding__input__field"
                        type="text"
                        value={bid}
                        onChange={handleBidChange}
                    />
                    <button className="modal__bidding__input__btn">
                        <RiCoinLine className="modal__bidding__input__btn__icon" />
                        <p className="modal__bidding__input__btn__text">Bet</p>
                    </button>
                </form>
            </div>
            <div className="modal__bidHistory">
                <p className="modal__bidHistory__text">Highests bids:</p>
                <div className="modal__bidHistory__highest">
                    {data && data.biddings.length > 0 ? (
                        <ul>
                            {data &&
                                data.biddings.map(
                                    ({ id, bid, user: { name, lastname } }) => (
                                        <li key={id}>
                                            <p>
                                                {name} {lastname}:
                                            </p>
                                            <p>{bid} €</p>
                                        </li>
                                    )
                                )}
                        </ul>
                    ) : (
                        <p>No biddings yet</p>
                    )}
                </div>
            </div>
        </BaseModal>
    );
};

export default Detailblury__modal;
