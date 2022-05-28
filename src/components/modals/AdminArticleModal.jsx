import { useContext, useState } from "react";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { usePostArticleMutation } from "../../data/articleAPI";

const AdminArticleblury__modal = () => {
    const { setModal, setActiveUser } = useContext(AppContext);

    const [formErrors, setFormErrors] = useState({
        art_name: "",
        art_img: "",
        art_cat_id: "",
    });

    const [inputs, setInputs] = useState({
        art_name: "",
        art_img: "",
        art_cat_id: "",
    });
    const [addArticle] = usePostArticleMutation();

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

        const { data, error } = await addArticle(inputs);

        if (data) {
            setInputs({});
            setModal(null);
        } else if (error) {
            setFormErrors({ ...formErrors, ...error.data });
        }
    }

    return (
        <BaseModal>
            <h1 className="modal__adminTitle">Add Article</h1>
            <form className="modal__adminInput" onSubmit={submitHandler}>
                <div className="modal__adminInput__item">
                    <p>art_name: </p>
                    <input
                        className="modal__adminInput__item__inputfield"
                        type="text"
                        value={inputs.art_name}
                        placeholder="name"
                        name="art_name"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__adminInput__item__error">
                        {formErrors.art_name}
                    </p>
                </div>
                <div className="modal__adminInput__item">
                    <p>art_img:</p>
                    <input
                        className="modal__adminInput__item__inputfield"
                        type="text"
                        value={inputs.art_img}
                        placeholder="image"
                        name="art_img"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__adminInput__item__error">
                        {formErrors.art_img}
                    </p>
                </div>
                <div className="modal__adminInput__item">
                    <p>art_cat_id: </p>
                    <input
                        className="modal__adminInput__item__inputfield"
                        type="text"
                        value={inputs.art_cat_id}
                        placeholder="category ID"
                        name="art_cat_id"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__adminInput__item__error">
                        {formErrors.art_cat_id}
                    </p>
                </div>
                <button className="modal__adminInput__btn">Add to DB</button>
            </form>
        </BaseModal>
    );
};

export default AdminArticleblury__modal;
