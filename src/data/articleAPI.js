import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const articleAPI = createApi({
    reducerPath: "articleState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getArticles: builder.query({
            query: () => "/articles",
            providesTags: ["allArticles"],
        }),
        getArticleById: builder.query({
            query: (id) => `/article/${id}`,
        }),
        postArticle: builder.mutation({
            query: ({ art_id, art_name, art_img, art_cat_id, csrf }) => ({
                url: `/articles`,
                method: "POST",
                body: {
                    art_id,
                    art_name,
                    art_img,
                    art_cat_id,
                    csrf,
                },
            }),
            invalidatesTags: ["allArticles"],
        }),
        patchArticleById: builder.mutation({
            query: ({ art_id, art_name, art_img, art_cat_id, csrf }) => ({
                url: `/article/${art_id}`,
                method: "PATCH",
                body: {
                    art_name,
                    art_img,
                    art_cat_id,
                    csrf,
                },
            }),
            invalidatesTags: ["allArticles"],
        }),
        deleteArticle: builder.mutation({
            query: (id) => ({
                url: `/article/${id}`,
                method: "DELETE",
            }),
            invalidatesTags: ["allArticles"],
        }),
        uploadImage: builder.mutation({
            query: (formData) => ({
                url: "/upload",
                method: "POST",
                body: formData,
            }),
        }),
    }),
});

export default articleAPI;
export const {
    useGetArticlesQuery,
    useGetArticleByIdQuery,
    usePostArticleMutation,
    usePatchArticleByIdMutation,
    useDeleteArticleMutation,
    useUploadImageMutation,
} = articleAPI;
