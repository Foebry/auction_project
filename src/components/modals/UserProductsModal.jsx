import Timer from "../Timer";
import { RiCoinLine } from "react-icons/ri";
import BaseModal from "./baseModal";
import { useContext } from "react";
import { AppContext } from "../../context/AppContext";
import { useGetAuctionByIdQuery } from "../../data/auctionAPI.js";

const Detailblury__modal = () => {
    const { modal } = useContext(AppContext);
    const { data, isError, isLoading } = useGetAuctionByIdQuery(modal, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    return (
        <BaseModal>
            <div className="modal__title">
                <h2>Mijn biedingen</h2>
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
