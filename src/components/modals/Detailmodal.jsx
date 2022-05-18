import Timer from "../Timer";
import { RiCoinLine } from "react-icons/ri";
import BaseModal from "./baseModal";
import { useContext } from "react";
import { AppContext } from "../../context/AppContext";
import { useGetAuctionByIdQuery } from "../../data/auctionAPI.js";

const Detailblury__modal = ({ expiration }) => {
    const { modal } = useContext(AppContext);
    const { data, isError, isLoading } = useGetAuctionByIdQuery(modal, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });
    console.log("detail:", data);
    return (
        <BaseModal>
            <div className="modal__title">
                {data && data.name && <h2>{data.name}</h2>}{" "}
            </div>
            <Timer rest={data && data.expiration} />
            <div className="modal__bidding">
                <p className="modal__bidding__text">Bet fast:</p>
                <div className="modal__bidding__fast">
                    <button className="modal__bidding__fast__btn">
                        <p className="modal__bidding__btn__text">+1 €</p>
                    </button>
                    <button className="modal__bidding__fast__btn">
                        <p className="modal__bidding__fast__btn__text">+2 €</p>
                    </button>
                    <button className="modal__bidding__fast__btn">
                        <p className="modal__bidding__btn__text">+5 €</p>
                    </button>
                </div>
                <div className="modal__bidding__input">
                    <input
                        className="modal__bidding__input__field"
                        type="text"
                    />
                    <button className="modal__bidding__input__btn">
                        <RiCoinLine className="modal__bidding__input__btn__icon" />
                        <p className="modal__bidding__input__btn__text">Bet</p>
                    </button>
                </div>
            </div>
            <div className="modal__bidHistory">
                <p className="modal__bidHistory__text">Highests bids:</p>
                <div className="modal__bidHistory__highest">
                    {data && data.biddings.length > 0 ? (
                        <ul>
                            {data &&
                                data.biddings.map((bid) => (
                                    <li key={bid.id}>
                                        <p>{bid.user.name} :</p>
                                        <p>{bid.bid} €</p>
                                    </li>
                                ))}
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
