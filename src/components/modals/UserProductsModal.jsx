import Timer from "../Timer";
import { RiCoinLine } from "react-icons/ri";
import BaseModal from "./baseModal";
import { useContext, useState } from "react";
import { AppContext } from "../../context/AppContext";
import { useGetUserAuctionsQuery } from "../../data/userAPI.js";

const UserProductblury__modal = () => {
    const { modal } = useContext(AppContext);
    const [status, setStatus] = useState(undefined);
    const { data, isError, isLoading } = useGetUserAuctionsQuery(
        { status },
        {
            pollingInterval: 0,
            refetchOnFocus: true,
            refetchOnReconnect: true,
        }
    );

    return (
        <BaseModal>
            <div className="modal__userTitle">
                <h2>Mijn Biedingen</h2>
            </div>
            <div className="modal__userSelect">
                <button
                    className="modal__userSelect__btn1"
                    onClick={() => {
                        setStatus({ status: 0 });
                    }}
                >
                    Actief
                </button>
                <button
                    className="modal__userSelect__btn2"
                    onClick={() => {
                        setStatus();
                    }}
                >
                    Gewonnen
                </button>
            </div>
            <div className="modal__userHistory">
                <p className="modal__userHistory__text">Articles</p>
                <div className="modal__userHistory__highest">
                    {data && data.length > 0 ? (
                        <ul>
                            {data &&
                                data.map((bid) => (
                                    <li key={bid.id}>
                                        <p>{bid.article.name} :</p>
                                        <p>{bid.price} €</p>
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

export default UserProductblury__modal;
