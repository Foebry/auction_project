import React from "react";
import Timer from "../Timer";
import { RiCoinLine } from "react-icons/ri";
import { useLocation } from "react-router-dom";
import { auctionDetail } from "../../mocks/auctionDetail.js";

const Detailmodal = ({ closeDetail }) => {
    const { state } = location;

    return (
        <div className="modalBackground">
            <div className="modalBackground__modalContainer">
                <div className="modalBackground__modalContainer__closeBtn">
                    <button onClick={() => closeDetail(false)}>X</button>
                </div>
                <div className="modalBackground__modalContainer__title">
                    <h2>{auctionDetail.name}</h2>{" "}
                </div>
                <div className="modalBackground__modalContainer__bidding">
                    <p className="modalBackground__modalContainer__bidding__text">
                        Bet fast:
                    </p>
                    <div className="modalBackground__modalContainer__bidding__fast">
                        <button className="modalBackground__modalContainer__bidding__fast__btn">
                            <p className="modalBackground__modalContainer__bidding__btn__text">
                                +1 €
                            </p>
                        </button>
                        <button className="modalBackground__modalContainer__bidding__fast__btn">
                            <p className="modalBackground__modalContainer__bidding__fast__btn__text">
                                +2 €
                            </p>
                        </button>
                        <button className="modalBackground__modalContainer__bidding__fast__btn">
                            <p className="modalBackground__modalContainer__bidding__btn__text">
                                +5 €
                            </p>
                        </button>
                    </div>
                    <div className="modalBackground__modalContainer__bidding__input">
                        <input
                            className="modalBackground__modalContainer__bidding__input__field"
                            type="text"
                        />
                        <button className="modalBackground__modalContainer__bidding__input__btn">
                            <RiCoinLine className="modalBackground__modalContainer__bidding__input__btn__icon" />
                            <p className="modalBackground__modalContainer__bidding__input__btn__text">
                                Bet
                            </p>
                        </button>
                    </div>
                </div>
                <div className="modalBackground__modalContainer__bidHistory">
                    <p className="modalBackground__modalContainer__bidHistory__text">
                        Highests bids:
                    </p>
                    <div className="modalBackground__modalContainer__bidHistory__highest">
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
            </div>
        </div>
    );
};

export default Detailmodal;
