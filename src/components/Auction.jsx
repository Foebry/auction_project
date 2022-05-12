import { useContext } from "react";
import { Routes } from "../types/RouteTypes";
import Detailmodal from "./modals/Detailmodal";
import BaseModal from "./modals/baseModal";
import { useNavigate } from "react-router-dom";
import Timer from "./Timer.jsx";
import { RiCoinLine } from "react-icons/ri";
import { AppContext } from "../context/AppContext";

const Auction = ({ id, name, expiration, highest_bid, image }) => {
    const { setModal } = useContext(AppContext);

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
                        <button
                            onClick={() => {
                                setModal(id);
                            }}
                            className="article__content__bid__btn"
                        >
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
