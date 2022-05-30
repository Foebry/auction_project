import { useContext, useState } from "react";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import ApiDropdown from "../../components/ApiDropdown";
import {
    usePostArticleMutation,
    useUploadImageMutation,
    usePatchArticleByIdMutation,
} from "../../data/articleAPI";

const AdminArticleblury__modal = () => {
    const { setModal, onClose, updateArticle, setUpdateArticle } =
        useContext(AppContext);
    const [image, setImage] = useState({});

    const [formErrors, setFormErrors] = useState({
        art_name: "",
        art_img: "",
        art_cat_id: "",
    });

    const [inputs, setInputs] = useState({
        art_name: "",
        art_img: null,
        art_cat_id: updateArticle?.art_cat_id ?? "",
    });
    const [addArticle] = usePostArticleMutation();
    const [patchArticle] = usePatchArticleByIdMutation();
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

        const { error: uploadError } =
            Object.keys(image).length === 0 ? {} : await uploadImage(formData);

        if (uploadError) {
            setFormErrors({ ...formErrors, ...formErrors.data });
        } else {
            const { data: artData, error: artError } = updateArticle
                ? await patchArticle({
                      ...inputs,
                      ...{ art_id: updateArticle.art_id },
                  })
                : await addArticle(inputs);

            if (artError) {
                setFormErrors({ ...formErrors, ...formErrors.data });
            } else if (artData) {
                setImage({});
                setInputs({});
                setUpdateArticle(null);
                setModal(null);
            }
        }
    }

    return (
        <BaseModal onClose={onClose}>
            <h1 className="modal__adminTitle">{`${
                updateArticle ? "Update" : "Add"
            } Article`}</h1>
            <form className="modal__adminInput" onSubmit={submitHandler}>
                <div className="modal__adminInput__item">
                    <p>art_name: </p>
                    <input
                        className="modal__adminInput__item__inputfield"
                        type="text"
                        value={inputs.art_name}
                        placeholder={updateArticle?.art_name ?? "name"}
                        name="art_name"
                        onChange={handleInputChange}
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
                    />
                    <p className="modal__adminInput__item__error">
                        {formErrors.art_img}
                    </p>
                </div>
                <div className="modal__adminInput__item">
                    <p>art_cat_id: </p>
                    <ApiDropdown
                        type="categories"
                        onChange={handleInputChange}
                        name="art_cat_id"
                        className="modal__adminInput__item__inputfield"
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
