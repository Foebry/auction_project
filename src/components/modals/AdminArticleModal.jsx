import { useContext, useState } from "react";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import {
    usePostArticleMutation,
    useUploadImageMutation,
} from "../../data/articleAPI";

const AdminArticleblury__modal = () => {
    const { setModal } = useContext(AppContext);
    const [image, setImage] = useState({});

    const [formErrors, setFormErrors] = useState({
        art_name: "",
        art_img: "",
        art_cat_id: "",
    });

    const [inputs, setInputs] = useState({
        art_name: "",
        art_img: null,
        art_cat_id: "",
    });
    const [addArticle] = usePostArticleMutation();
    const [uploadImage] = useUploadImageMutation();

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

    const handleFileChange = (e) => {
        setImage(e.target.files[0]);
        setInputs({ ...inputs, art_img: e.target.files[0].name });
    };

    async function submitHandler(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append("image", image);

        const { error: uploadError } = await uploadImage(formData);

        if (uploadError) {
            setFormErrors({ ...formErrors, ...formErrors.data });
        } else {
            const { data: artData, error: artError } = await addArticle(inputs);

            if (artError) {
                setFormErrors({ ...formErrors, ...formErrors.data });
            } else if (artData) {
                setImage({});
                setInputs({});
                setModal(null);
            }
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
                        type="file"
                        placeholder="image"
                        name="art_img"
                        onChange={handleFileChange}
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
