import React from "react";
import Timer from "../Timer";
import { RiCoinLine } from "react-icons/ri";
import { auctionDetail } from "../../mocks/auctionDetail.js";
import BaseModal from "./baseModal";

const Detailblury__modal = ({ expiration }) => {
    const { state } = location;

    return (
        <BaseModal>
            <div className="modal__title">
                <h2>{auctionDetail.name}</h2>{" "}
            </div>
            <Timer rest={expiration} />
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
                    {auctionDetail.biddings.length > 0 ? (
                        <ul>
                            {auctionDetail.biddings.map((bid) => (
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
