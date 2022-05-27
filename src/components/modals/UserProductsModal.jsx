import Timer from "../Timer";
import { RiCoinLine } from "react-icons/ri";
import BaseModal from "./baseModal";
import { useContext } from "react";
import { AppContext } from "../../context/AppContext";
import { useGetUserBiddingsQuery } from "../../data/userAPI.js";

const Detailblury__modal = () => {
    const { modal } = useContext(AppContext);
    const { data, isError, isLoading } = useGetUserBiddingsQuery(modal, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });
    console.log({ modal });

    return (
        <BaseModal>
            <div className="modal__userTitle">
                <h2>My Biddings</h2>
            </div>
            <div className="modal__userHistory">
                <p className="modal__userHistory__text">Articles</p>
                <div className="modal__userHistory__highest">
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
