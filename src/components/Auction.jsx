import React from "react";
import Timer from "./Timer.jsx";
import { RiCoinLine } from "react-icons/ri";

const Auction = ({ id, name, expiration, highest_bid, image }) => {
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
                    <div className="article__content__title">
                        <h2>{name}</h2>
                    </div>
                    <Timer rest={expiration} />
                    <div className="article__content__bid">
                        <p>{highest_bid}</p>
                        <button className="article__content__bid__btn">
                            <RiCoinLine className="article__content__bid__btn__icon" />
                            <p className="article__content__bid__btn__text">
                                Bet
                            </p>
                        </button>
                    </div>
                </div>
            </article>
        </>
    );
};

export default Auction;
