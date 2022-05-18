import { useContext } from "react";
import Timer from "./Timer.jsx";
import { RiCoinLine } from "react-icons/ri";
import { AppContext } from "../context/AppContext";

const Auction = ({ id, name, expiration, highest_bid, image }) => {
    const { setModal } = useContext(AppContext);
    // const { data, isError, isLoading } = useGetAuctionByIdQuery(undefined, {
    //     pollingInterval: 0,
    //     refetchOnFocus: true,
    //     refetchOnReconnect: true,
    // });
    //console.log("auction data:", data);

    return (
        <article className="article">
            <div className="article__imgholder">
                {(image && (
                    <img
                        className="article__imgholder__img"
                        src={image}
                        alt="#"
                    ></img>
                )) || <p>no image</p>}
            </div>
            <div className="article__content">
                {name && (
                    <div className="article__content__title">
                        <h2>{name}</h2>
                    </div>
                )}
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
                        <p className="article__content__bid__btn__text">Bet</p>
                    </button>
                </div>
            </div>
        </article>
    );
};

export default Auction;
