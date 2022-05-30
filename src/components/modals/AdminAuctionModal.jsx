import { useContext, useState } from "react";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { usePostAuctionMutation } from "../../data/auctionAPI";
import { useUpdateAuctionMutation } from "../../data/auctionAPI";
import ApiDropdown from "../ApiDropdown";

const AdminAuctionblury__modal = ({ method }) => {
    const { setModal, onClose, updateAuction, setUpdateAuction } =
        useContext(AppContext);

    const [formErrors, setFormErrors] = useState({
        auc_art_id: "",
        auc_start: "",
        auc_expiration: "",
    });

    const [inputs, setInputs] = useState({
        auc_art_id: updateAuction?.auc_art_id ?? "",
        auc_start: updateAuction?.auc_start ?? "",
        auc_expiration: updateAuction?.auc_expiration ?? "",
        id: updateAuction?.auc_id ?? "",
    });
    const [addAuction] = usePostAuctionMutation();
    const [patchAuction] = useUpdateAuctionMutation();

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

        const { data, error } =
            method === "POST"
                ? await addAuction(inputs)
                : method === "PATCH"
                ? await patchAuction(inputs)
                : null;

        if (data) {
            setInputs({});
            setModal(null);
            setUpdateAuction(null);
        } else if (error) {
            setFormErrors({ ...formErrors, ...error.data });
        }
    }

    return (
        <BaseModal onClose={onClose}>
            <h1 className="modal__adminTitle">Add Auction</h1>
            <form className="modal__adminInput" onSubmit={submitHandler}>
                <div className="modal__adminInput__item">
                    <p>auc_art_id: </p>
                    <ApiDropdown
                        onChange={handleInputChange}
                        name="auc_art_id"
                        type="articles"
                        value={updateAuction}
                    />
                    {/* <input
                        className="modal__adminInput__item__numberfield"
                        type="number"
                        value={inputs.auc_art_id}
                        placeholder="Article"
                        name="auc_art_id"
                        onChange={handleInputChange}
                        required
                    /> */}
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
