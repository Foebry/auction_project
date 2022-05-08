import React from "react";
import { Routes } from "../types/RouteTypes";
import { useNavigate } from "react-router-dom";
import Timer from "./Timer.jsx";
import { RiCoinLine } from "react-icons/ri";

const Auction = ({ id, name, expiration, highest_bid, image }) => {
    const navigate = useNavigate();
    return (
        <>
            <article className="article">
                <div className="article__imgholder">
                    <img
                        className="article__imgholder__img"
                        src={image}
                        alt="#"
                    ></img>
                </div>
                <div className="article__content">
                    <div className="article__heading">
                        <div className="article__heading__content">
                            <div className="article__content__title">
                                <h2>{name}</h2>
                            </div>
                            <div className="article__content__desc">
                                <p>
                                    <span>
                                        Lorem ipsum dolor sit amet, consectetur
                                        adipisicing elit. Quis earum laudantium
                                        et nihil Lorem ipsum dolor sit amet,
                                        consectetur adipisicing elit. Quis earum
                                        laudantium et nihil Lorem ipsum dolor
                                        sit amet, consectetur adipisicing elit.
                                        Quis earum laudantium et nihil
                                    </span>
                                </p>
                            </div>
                        </div>
                        <Timer rest={expiration} />
                    </div>

                    <div className="article__content__bid">
                        <div className="article__content__highest">
                            <p>€ {highest_bid}</p>
                        </div>
                        <button
                            className="article__content__bid__btn"
                            onClick={() =>
                                navigate(Routes.AUCTION_DETAIL, {
                                    state: { auction_id: id, expiration },
                                })
                            }
                        >
                            <RiCoinLine className="article__content__bid__btn__icon" />
                            <p className="article__content__bid__btn__text">
                                Bid
                            </p>
                        </button>
                    </div>
                </div>
            </article>
        </>
    );
};

export default Auction;
