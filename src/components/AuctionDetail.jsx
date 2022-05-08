import React from "react";
import Timer from "./Timer";
import { RiCoinLine } from "react-icons/ri";
import { auctionDetail } from "../mocks/auctionDetail.js";
import { useLocation } from "react-router-dom";

const AuctionDetail = () => {
    const location = useLocation();

    const { state } = location;
    return (
        <>
            <article className="articleDetail">
                <div className="articleDetail__imgholder">
                    <img
                        className="articleDetail__imgholder__img"
                        src={auctionDetail.image}
                        alt="#"
                    ></img>
                    <div className="articleDetail__imgholder__title">
                        <h2>artikel: {auctionDetail.name}</h2>
                    </div>
                </div>
                <div className="articleDetail__content">
                    <Timer rest={state.expiration} />
                    <div className="articleDetail__content__bid">
                        <p className="articleDetail__content__bid__fasttext">
                            Bet fast:
                        </p>
                        <div className="articleDetail__content__bid__fast">
                            <button className="articleDetail__content__bid__fast__btn">
                                <p className="articleDetail__content__bid__fast__btn__text">
                                    +1 €
                                </p>
                            </button>
                            <button className="articleDetail__content__bid__fast__btn">
                                <p className="articleDetail__content__bid__fast__btn__text">
                                    +2 €
                                </p>
                            </button>
                            <button className="articleDetail__content__bid__fast__btn">
                                <p className="articleDetail__content__bid__fast__btn__text">
                                    +5 €
                                </p>
                            </button>
                        </div>
                        <div className="articleDetail__content__bid__input">
                            <input
                                className="articleDetail__content__bid__input__field"
                                type="text"
                            />
                            <button className="articleDetail__content__bid__input__btn">
                                <RiCoinLine className="articleDetail__content__bid__input__btn__icon" />
                                <p className="articleDetail__content__bid__input__btn__text">
                                    Bet
                                </p>
                            </button>
                        </div>
                        <p className="articleDetail__content__bid__fasttext">
                            Highests bids:
                        </p>
                        <div className="articleDetail__content__bid__highest">
                            {auctionDetail.biddings.length > 0 ? (
                                <ul>
                                    {auctionDetail.biddings.map((bid) => (
                                        <li key={bid.id}>
                                            {bid.user.name} : {bid.bid} €
                                        </li>
                                    ))}
                                </ul>
                            ) : (
                                <p>No biddings yet</p>
                            )}
                        </div>
                    </div>
                </div>
            </article>
        </>
    );
};

export default AuctionDetail;
