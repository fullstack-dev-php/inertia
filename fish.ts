import * as Yup from 'yup'

export interface FishContent {
  id?: number
  name: string
  description: string
  fish_media?: Array<FishMediaContent | FishMedia>
}

export type Fish = FishContent &
  WithFishMedias & {
    id: number
  }
type WithFishMedias = {
  fish_media: Array<FishMediaContent | FishMedia>
}

export interface FishMediaContent {
  id ?: number,
  status: 'create' | 'update' | 'delete'
  upload_file : File
  url : string,
}
export interface FishMedia extends FishMediaContent {
  fish_id: number,
  file_id : number,
  file :{
    path : string,
  }
}

export function getNewFish(): FishContent & WithFishMedias {
  return {
    name: '',
    description: '',
    fish_media: []
  }
}
export type FishFormData = FishContent & WithFishMedias

export const createFishValidateSchema = () =>
  Yup.object<FishFormData>().shape({
    name: Yup.string()
      .required('Name is required')
      .max(255, 'Name must be at most 255 characters'),
    description: Yup.string()
      .required('Description is required')
      .max(600, 'Description must be at most 600 characters')
  })
