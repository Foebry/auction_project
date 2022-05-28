import { useContext, useState } from "react";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { usePostAuctionMutation } from "../../data/auctionAPI";

const AdminAuctionblury__modal = () => {
    const { setModal, setActiveUser } = useContext(AppContext);

    const [formErrors, setFormErrors] = useState({
        auc_art_id: "",
        auc_start: "",
        auc_expiration: "",
    });

    const [inputs, setInputs] = useState({
        auc_art_id: "",
        auc_start: "",
        auc_expiration: "",
    });
    const [addAuction] = usePostAuctionMutation();

    const handleInputChange = (e) => {
        setInputs({
            ...inputs,
            [e.target.name]: e.target.value,
        });
        setFormErrors({
            ...formErrors,
            [e.target.name]: "",
        });
    };

    async function submitHandler(e) {
        e.preventDefault();

        const { data, error } = await addAuction(inputs);

        if (data) {
            setInputs({});
            setModal(null);
        } else if (error) {
            setFormErrors({ ...formErrors, ...error.data });
        }
    }

    return (
        <BaseModal>
            <h1 className="modal__adminTitle">Add Auction</h1>
            <form className="modal__adminInput" onSubmit={submitHandler}>
                <div className="modal__adminInput__item">
                    <p>auc_art_id: </p>
                    <input
                        className="modal__adminInput__item__inputfield"
                        type="text"
                        value={inputs.auc_art_id}
                        placeholder="Article ID"
                        name="auc_art_id"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__adminInput__item__error">
                        {formErrors.auc_art_id}
                    </p>
                </div>
                <div className="modal__adminInput__item">
                    <p>auc_start: </p>
                    <input
                        className="modal__adminInput__item__timefield"
                        type="datetime-local"
                        value={inputs.auc_start}
                        name="auc_start"
                        onChange={handleInputChange}
                    />
                    <p className="modal__adminInput__item__error">
                        {formErrors.auc_start}
                    </p>
                </div>
                <div className="modal__adminInput__item">
                    <p>auc_expiration: </p>
                    <input
                        className="modal__adminInput__item__timefield"
                        type="datetime-local"
                        value={inputs.auc_expiration}
                        name="auc_expiration"
                        onChange={handleInputChange}
                    />
                    <p className="modal__adminInput__item__error">
                        {formErrors.auc_expiration}
                    </p>
                </div>
                <button className="modal__adminInput__btn">Add to DB</button>
            </form>
        </BaseModal>
    );
};

export default AdminAuctionblury__modal;
